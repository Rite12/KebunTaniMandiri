<?php

namespace App\Http\Controllers;

use App\Models\RekapKerja;
use App\Models\Karyawan;
use App\Models\LokasiSawit;
use App\Models\Hutang;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapKerjaController extends Controller
{
    public function index(Request $request)
{
    $bulan = $request->input('bulan', date('m'));
    $tahun = $request->input('tahun', date('Y'));
    $search = $request->input('search'); // Menerima input pencarian

    $karyawans = Karyawan::query()
        ->when($search, function ($query) use ($search) {
            return $query->where('nama_lengkap', 'like', '%' . $search . '%');
        })
        ->paginate(10); // Menambahkan paginate

    return view('rekap_kerja.index', compact('karyawans', 'bulan', 'tahun'));
}


    public function create($karyawan_id)
    {
        $karyawan = Karyawan::findOrFail($karyawan_id);
        $lokasiSawit = LokasiSawit::all();
        return view('rekap_kerja.create', compact('karyawan', 'lokasiSawit'));
    }

     public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'karyawan_id'      => 'required|exists:karyawans,id',
            'tanggal'          => 'required|date',
            'jenis_kerjaan'    => 'required|string|max:255',
            'banyak'           => 'required|string',
            'upah'             => 'required|numeric',
            'keterangan'       => 'nullable|string|max:255',
            'lokasi_sawit_id'  => 'required|exists:lokasi_sawit,id',
        ]);

        // Parse the 'banyak' field to handle non-numeric characters
        $banyakAngka = preg_replace('/[^0-9.,]/', '', $validated['banyak']);
        $banyakAngka = str_replace(',', '.', $banyakAngka);
        $banyakAngka = floatval($banyakAngka);

        // Calculate the 'jumlah' field (amount)
        $validated['jumlah'] = $banyakAngka * $validated['upah'];

        // Save the RekapKerja record
        RekapKerja::create($validated);

        // Redirect with success message
        return redirect()->route('rekap_kerja.index')->with('success', 'Rekap kerja berhasil ditambahkan!');
    }

    public function detail($id, Request $request)
{
    // Get the selected month and year from the request (or default to current month and year)
    $bulan = $request->input('bulan', date('m')); // Default to current month
    $tahun = $request->input('tahun', date('Y')); // Default to current year

    // Pass selected month and year to the view
    $selectedBulan = $bulan;
    $selectedTahun = $tahun;

    // Find the employee
    $karyawan = Karyawan::findOrFail($id);

    // Retrieve the kerja data for the specified month and year
    $kerja = RekapKerja::where('karyawan_id', $id)
        ->whereYear('tanggal', $tahun)
        ->whereMonth('tanggal', $bulan)
        ->with('lokasiSawit')
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'tanggal' => $item->tanggal,
                'jenis' => 'Kerja',
                'jenis_kerjaan' => $item->jenis_kerjaan,
                'lokasi' => optional($item->lokasiSawit)->nama_lokasi,
                'banyak' => $item->banyak,
                'upah' => $item->upah,
                'jumlah' => $item->jumlah,
            ];
        });

    // Retrieve the lembur (overtime) data for the specified month and year
    $lembur = Kehadiran::where('karyawan_id', $id)
        ->whereYear('tanggal', $tahun)
        ->whereMonth('tanggal', $bulan)
        ->where('jam_lembur', '>', 0)
        ->get()
        ->map(function ($item) {
            return [
                'id' => null,
                'tanggal' => $item->tanggal,
                'jenis' => 'Lembur',
                'jenis_kerjaan' => 'Lembur',
                'lokasi' => null,
                'banyak' => number_format($item->jam_lembur, 2) . ' jam',
                'upah' => $item->gaji_lembur,
                'jumlah' => $item->total_gaji_lembur,
            ];
        });

    // Merge kerja and lembur data, then sort by date
    $rekapGabungan = $kerja->merge($lembur)->sortBy('tanggal')->values();

    // Calculate the totals for gaji, lembur, and hutang
    $totalGajiKerja = $kerja->sum('jumlah');
    $totalLembur = $lembur->sum('jumlah');
    $totalGaji = $totalGajiKerja + $totalLembur;

    // Calculate total hutang and sisa gaji
    $totalHutang = Hutang::where('karyawan_id', $id)->sum('jumlah');
    $sisaGaji = $totalGaji - $totalHutang;

    // Pass all necessary data to the view
    return view('rekap_kerja.detail', compact(
        'rekapGabungan', 'karyawan', 'bulan', 'tahun', 'selectedBulan', 'selectedTahun',
        'totalGajiKerja', 'totalLembur', 'totalGaji', 'totalHutang', 'sisaGaji'
    ));
}


    public function storeHutang(Request $request)
    {
        if (!Auth::user()->hasRole('mandor')) {
            abort(403);
        }

        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'jumlah'      => 'required|numeric|min:1',
            'keterangan'  => 'nullable|string|max:255',
            'tanggal'     => 'required|date',
        ]);

        $jumlah = (int) preg_replace('/[^0-9]/', '', $validated['jumlah']);

        Hutang::create([
            'karyawan_id' => $validated['karyawan_id'],
            'jumlah'      => $jumlah,
            'keterangan'  => $validated['keterangan'] ?? null,
            'tanggal'     => $validated['tanggal'],
        ]);

        return back()->with('success', 'Hutang berhasil ditambahkan!');
    }

    public function kurangiHutang(Request $request, $karyawan_id)
    {
        if (!Auth::user()->hasRole('mandor')) {
            abort(403);
        }

        $validated = $request->validate([
            'jumlah'     => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $jumlah = preg_replace('/[^0-9]/', '', $validated['jumlah']);

        Hutang::create([
            'karyawan_id' => $karyawan_id,
            'jumlah' => -$jumlah,
            'tanggal' => $validated['tanggal'],
            'keterangan' => $validated['keterangan'] ?? 'Pengurangan hutang',
        ]);

        return back()->with('success', 'Hutang berhasil dikurangi!');
    }

    public function formHutang($id)
    {
        if (!Auth::user()->hasRole('mandor')) {
            abort(403);
        }

        $karyawan = Karyawan::findOrFail($id);
        return view('rekap_kerja.form_hutang', compact('karyawan'));
    }

    public function prosesHutang(Request $request)
    {
        if (!Auth::user()->hasRole('mandor')) {
            abort(403);
        }

        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'jumlah'      => 'required|numeric|min:1',
            'tanggal'     => 'required|date',
            'keterangan'  => 'nullable|string|max:255',
            'tipe'        => 'required|in:tambah,kurangi',
        ]);

        $jumlah = (int) preg_replace('/[^0-9]/', '', $validated['jumlah']);

        if ($validated['tipe'] === 'kurangi') {
            $jumlah = -$jumlah;
        }

        Hutang::create([
            'karyawan_id' => $validated['karyawan_id'],
            'jumlah'      => $jumlah,
            'tanggal'     => $validated['tanggal'],
            'keterangan'  => $validated['keterangan'] ?? ($validated['tipe'] === 'kurangi' ? 'Pengurangan hutang' : 'Tambah hutang'),
        ]);

        return redirect()->route('rekap_kerja.detail', $validated['karyawan_id'])
                         ->with('success', 'Transaksi hutang berhasil disimpan.');
    }

    // Fungsi untuk menghasilkan Slip Gaji dalam format PDF
    // Controller: generateRekapKerjaPDF method

public function generateRekapKerjaPDF(Request $request, $id)
    {
        // Fetch employee data by ID
        $karyawan = Karyawan::findOrFail($id);

        // Fetch the work summary (RekapKerja) data for the specified employee, year, and month
        $rekapKerja = RekapKerja::where('karyawan_id', $id)
            ->whereYear('tanggal', $request->input('tahun', date('Y')))
            ->whereMonth('tanggal', $request->input('bulan', date('m')))
            ->get();

        // Calculate total salary (gaji), overtime (lembur), and debt (hutang)
        $totalGajiKerja = $rekapKerja->sum('jumlah');
        $totalLembur = Kehadiran::where('karyawan_id', $id)
            ->whereYear('tanggal', $request->input('tahun', date('Y')))
            ->whereMonth('tanggal', $request->input('bulan', date('m')))
            ->sum('total_gaji_lembur');
        $totalGaji = $totalGajiKerja + $totalLembur;

        // Calculate total debt
        $totalHutang = Hutang::where('karyawan_id', $id)->sum('jumlah');
        $sisaGaji = $totalGaji - $totalHutang;

        // Prepare data for the PDF
        $data = [
            'nama_lengkap' => $karyawan->nama_lengkap,
            'bulan' => $request->input('bulan', date('m')),
            'tahun' => $request->input('tahun', date('Y')),
            'rekapKerja' => $rekapKerja,
            'totalGaji' => $totalGaji,
            'totalHutang' => $totalHutang,
            'sisaGaji' => $sisaGaji,
        ];

        // Generate Rekap Kerja PDF
        $pdf = PDF::loadView('rekap_kerja.detail_rekap_kerja_pdf', $data); // Make sure the view path is correct
        return $pdf->download('rekap_kerja_' . $karyawan->nama_lengkap . '.pdf');
    }

    // Method to generate Slip Gaji PDF
    public function generateSlipGajiPDF(Request $request, $id)
    {
        // Fetch employee data by ID
        $karyawan = Karyawan::findOrFail($id);

        // Fetch the work summary (RekapKerja) data for the specified employee, year, and month
        $rekapKerja = RekapKerja::where('karyawan_id', $id)
            ->whereYear('tanggal', $request->input('tahun', date('Y')))
            ->whereMonth('tanggal', $request->input('bulan', date('m')))
            ->get();

        // Calculate total salary (gaji), overtime (lembur), and debt (hutang)
        $totalGajiKerja = $rekapKerja->sum('jumlah');
        $totalLembur = Kehadiran::where('karyawan_id', $id)
            ->whereYear('tanggal', $request->input('tahun', date('Y')))
            ->whereMonth('tanggal', $request->input('bulan', date('m')))
            ->sum('total_gaji_lembur');
        $totalGaji = $totalGajiKerja + $totalLembur;

        // Calculate total debt
        $totalHutang = Hutang::where('karyawan_id', $id)->sum('jumlah');
        $sisaGaji = $totalGaji - $totalHutang;

        // Prepare data for the PDF
        $data = [
            'nama_lengkap' => $karyawan->nama_lengkap,
            'bulan' => $request->input('bulan', date('m')),
            'tahun' => $request->input('tahun', date('Y')),
            'totalGaji' => $totalGaji,
            'totalHutang' => $totalHutang,
            'sisaGaji' => $sisaGaji,
        ];

        // Generate Slip Gaji PDF
        $pdf = PDF::loadView('rekap_kerja.slip_gaji_form', $data); // Make sure the path is correct
        return $pdf->download('slip_gaji_' . $karyawan->nama_lengkap . '.pdf');
    }

    public function edit($id)
{
    // Find the Rekap Kerja record
    $rekapKerja = RekapKerja::findOrFail($id);
    $lokasiSawit = LokasiSawit::all(); // Get the list of lokasi sawit (optional)

    return view('rekap_kerja.edit', compact('rekapKerja', 'lokasiSawit'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'karyawan_id'      => 'required|exists:karyawans,id',
        'tanggal'          => 'required|date',
        'jenis_kerjaan'    => 'required|string|max:255',
        'banyak'           => 'required|string',
        'upah'             => 'required|numeric',
        'keterangan'       => 'nullable|string|max:255',
        'lokasi_sawit_id'  => 'required|exists:lokasi_sawit,id',
    ]);

    $rekapKerja = RekapKerja::findOrFail($id);

    // Process and save Rekap Kerja if the employee is active
    $banyakAngka = preg_replace('/[^0-9.,]/', '', $validated['banyak']);
    $banyakAngka = str_replace(',', '.', $banyakAngka);
    $banyakAngka = floatval($banyakAngka);

    // Calculate 'jumlah' as quantity * unit price
    $validated['jumlah'] = $banyakAngka * $validated['upah'];

    // Update Rekap Kerja
    $rekapKerja->update($validated);

    return redirect()->route('rekap_kerja.index')->with('success', 'Rekap kerja berhasil diperbarui!');
}
public function destroy($id)
{
    // Find the Rekap Kerja record and delete it
    $rekapKerja = RekapKerja::findOrFail($id);
    $rekapKerja->delete();

    return redirect()->route('rekap_kerja.index')->with('success', 'Rekap kerja berhasil dihapus!');
}



}
