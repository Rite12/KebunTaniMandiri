@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')

@php
    use Carbon\Carbon;
    $selectedTanggal = request('tanggal', now()->toDateString());
@endphp

<!-- Judul -->
<h5 class="mb-4 d-flex align-items-right gap-2"
    style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.5rem; color: #212529;">
    <i class="fas fa-tree text-success"></i> <span>Lokasi Sawit</span>
</h5>

<!-- Success Alert -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Peta Lokasi Sawit -->
<div id="map" style="height: 400px; border: 1px solid #ddd; margin-bottom: 20px;"></div>

<!-- Tabel Lokasi Sawit -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            @if($lokasi_sawit->count() > 0)
            <table class="table table-bordered table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Lokasi</th>
                        <th>Luas Lahan (ha)</th>
                        <th>Jenis Tanaman</th>
                        <th>Kondisi Tanaman</th>
                        <th>Koordinat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lokasi_sawit as $lokasi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $lokasi->nama_lokasi }}</td>
                        <td>{{ $lokasi->luas_lahan }}</td>
                        <td>{{ $lokasi->jenis_tanaman }}</td>
                        <td>{{ $lokasi->kondisi_tanaman }}</td>
                        <td>{{ $lokasi->latitude }}, {{ $lokasi->longitude }}</td>
                        <td>
                            <a href="{{ route('lokasi_sawit.edit', $lokasi->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('lokasi_sawit.destroy', $lokasi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Tidak ada data lokasi sawit.
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Button Add Location and Back -->
<div class="d-flex justify-content-end gap-2 mb-4">
    <!-- Kembali Button -->
    <a href="{{ route('fitur.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <!-- Tambah Lokasi Sawit Button -->
    <a href="{{ route('lokasi_sawit.create') }}" class="btn btn-success btn-sm">
        <i class="fas fa-plus-circle"></i> Tambah Lokasi Sawit
    </a>
</div>


<script>
    var map = L.map('map').setView([-1.607, 103.610], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    @foreach($lokasi_sawit as $lokasi)
        L.marker([{{ $lokasi->latitude }}, {{ $lokasi->longitude }}])
            .addTo(map)
            .bindPopup("<b>{{ $lokasi->nama_lokasi }}</b><br>{{ $lokasi->jenis_tanaman }}<br>{{ $lokasi->kondisi_tanaman }}");
    @endforeach
</script>

@endsection
