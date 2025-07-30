<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KegiatanController extends Controller
{
    // Menampilkan list kegiatan dengan filter tanggal
    public function index(Request $request)
{
    $tanggal = $request->tanggal ?? Carbon::today()->format('d/m/Y');

    try {
        $tanggalFormatted = Carbon::createFromFormat('d/m/Y', $tanggal)->toDateString();
    } catch (\Exception $e) {
        return back()->with('error', 'Tanggal tidak valid');
    }

    // Ambil data kegiatan sesuai dengan tanggal yang difilter
    $kegiatans = Kegiatan::whereDate('tanggal', $tanggalFormatted)->get();

    // Hitung total banyak, harga, jumlah
    $totalBanyak = $kegiatans->sum('banyak');
    $totalHarga = $kegiatans->sum('harga');
    $totalJumlah = $kegiatans->sum('jumlah'); // Subtotal hanya jumlah yang relevan

    return view('kegiatan.index', compact('kegiatans', 'tanggal', 'totalBanyak', 'totalHarga', 'totalJumlah'));
}


    // Tampilkan form tambah kegiatan
    public function create()
    {
        return view('kegiatan.create');
    }

    // Simpan data kegiatan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'banyak' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal' => 'required|date_format:d/m/Y',
            'keterangan' => 'nullable|string',
        ]);

        $validated['jumlah'] = $validated['banyak'] * $validated['harga'];
        $validated['tanggal'] = Carbon::createFromFormat('d/m/Y', $validated['tanggal'])->toDateString();

        Kegiatan::create($validated);

        return redirect()->route('kegiatan.index')->with('success', 'Data kegiatan berhasil ditambahkan.');
    }

    // Tampilkan form edit kegiatan
    public function edit(Kegiatan $kegiatan)
    {
        $kegiatan->tanggal = Carbon::parse($kegiatan->tanggal)->format('d/m/Y');
        return view('kegiatan.edit', compact('kegiatan'));
    }

    // Update data kegiatan
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'banyak' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal' => 'required|date_format:d/m/Y',
            'keterangan' => 'nullable|string',
        ]);

        $validated['jumlah'] = $validated['banyak'] * $validated['harga'];
        $validated['tanggal'] = Carbon::createFromFormat('d/m/Y', $validated['tanggal'])->toDateString();

        $kegiatan->update($validated);

        return redirect()->route('kegiatan.index')->with('success', 'Data kegiatan berhasil diperbarui.');
    }

    // Hapus data kegiatan
    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();
        return redirect()->route('kegiatan.index')->with('success', 'Data kegiatan berhasil dihapus.');
    }
}
