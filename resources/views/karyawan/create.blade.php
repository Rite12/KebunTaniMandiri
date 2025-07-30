@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')
<div class="container" style="max-width: 650px;">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white font-weight-bold text-center">
            Form Tambah Karyawan
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('karyawan.store') }}">
                @csrf

                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required>
                    @error('nama_lengkap')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jabatan -->
                <div class="form-group mt-3">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}" required>
                    @error('jabatan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group mt-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div class="form-group mt-3">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control @error('nomor_telepon') is-invalid @enderror" value="{{ old('nomor_telepon') }}" required>
                    @error('nomor_telepon')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="form-group mt-3">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol di Bawah (Kanan) -->
                <div class="d-flex justify-content-end align-items-center gap-2 mt-4">
                    <a href="{{ route('karyawan.index') }}" class="btn btn-md btn-secondary border text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                        <i class="fas fa-arrow-left"></i> <span>Kembali</span>
                    </a>

                    <button type="submit" class="btn btn-md btn-success fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                        <i class="fas fa-save"></i> <span>Simpan Karyawan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
