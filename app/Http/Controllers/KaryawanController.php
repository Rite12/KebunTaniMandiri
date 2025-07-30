<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    // Tampilkan daftar karyawan dengan pagination
    public function index(Request $request)
{
    // Get the search query from the request
    $search = $request->input('search');
    
    // If there is a search term, filter the Karyawan model by name
    $karyawans = Karyawan::when($search, function ($query, $search) {
        return $query->where('nama_lengkap', 'like', '%' . $search . '%');
    })
    ->paginate(10);

    // Return the view with the filtered karyawans
    return view('karyawan.index', compact('karyawans'));
}

    // Tampilkan form tambah karyawan
    public function create()
    {
        // hanya mandor
        $this->authorize('create karyawan');
        return view('karyawan.create');
    }

    // Simpan karyawan baru
    public function store(Request $request)
    {
        // hanya mandor
        $this->authorize('create karyawan');

        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'jabatan'        => 'required|string|max:255',
            'status'         => 'required|string|max:255',
            'nomor_telepon'  => 'required|string|max:15',
            'alamat'         => 'required|string|max:255',
        ]);

        Karyawan::create($validated);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    // Tampilkan form edit karyawan
    public function edit($id)
    {
        // hanya mandor
        $this->authorize('update karyawan');

        $karyawan = Karyawan::findOrFail($id);
        return view('karyawan.edit', compact('karyawan'));
    }

    // Update data karyawan
    public function update(Request $request, $id)
    {
        // hanya mandor
        $this->authorize('update karyawan');

        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'jabatan'        => 'required|string|max:255',
            'status'         => 'required|string|max:255',
            'nomor_telepon'  => 'required|string|max:15',
            'alamat'         => 'required|string|max:255',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($validated);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    // Hapus karyawan
    public function destroy($id)
    {
        // hanya mandor
        $this->authorize('delete karyawan');

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus!');
    }
}
