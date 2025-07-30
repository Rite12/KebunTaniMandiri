@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')
<div class="container" style="max-width: 650px;">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white font-weight-bold text-center">
            Form Edit Lokasi Sawit
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('lokasi_sawit.update', $lokasiSawit->id) }}">
                @csrf
                @method('PUT')

                <!-- Nama Lokasi -->
                <div class="form-group">
                    <label for="nama_lokasi">Nama Lokasi</label>
                    <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" value="{{ old('nama_lokasi', $lokasiSawit->nama_lokasi) }}" required>
                </div>

                <!-- Luas Lahan -->
                <div class="form-group mt-3">
                    <label for="luas_lahan">Luas Lahan (ha)</label>
                    <input type="number" name="luas_lahan" id="luas_lahan" class="form-control" value="{{ old('luas_lahan', $lokasiSawit->luas_lahan) }}" required>
                </div>

                <!-- Jenis Tanaman -->
                <div class="form-group mt-3">
                    <label for="jenis_tanaman">Jenis Tanaman</label>
                    <input type="text" name="jenis_tanaman" id="jenis_tanaman" class="form-control" value="{{ old('jenis_tanaman', $lokasiSawit->jenis_tanaman) }}" required>
                </div>

                <!-- Kondisi Tanaman -->
                <div class="form-group mt-3">
                    <label for="kondisi_tanaman">Kondisi Tanaman</label>
                    <input type="text" name="kondisi_tanaman" id="kondisi_tanaman" class="form-control" value="{{ old('kondisi_tanaman', $lokasiSawit->kondisi_tanaman) }}" required>
                </div>

                <!-- Latitude -->
                <div class="form-group mt-3">
                    <label for="latitude">Latitude</label>
                    <input type="number" step="any" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $lokasiSawit->latitude) }}" required>
                </div>

                <!-- Longitude -->
                <div class="form-group mt-3">
                    <label for="longitude">Longitude</label>
                    <input type="number" step="any" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $lokasiSawit->longitude) }}" required>
                </div>

                <!-- Submit Button -->
                <div class="form-group mt-4 text-right">
                    <a href="{{ route('lokasi_sawit.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
