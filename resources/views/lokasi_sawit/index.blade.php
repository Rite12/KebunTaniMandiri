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

<!-- Custom CSS untuk area labels -->
<style>
.area-label {
    background: none !important;
    border: none !important;
}

.special-marker {
    background-color: #dc3545 !important;
    color: white !important;
    border-radius: 50% !important;
    width: 25px !important;
    height: 25px !important;
    border: 2px solid white !important;
    box-shadow: 0 1px 3px rgba(0,0,0,.5) !important;
}
</style>

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
    var map = L.map('map').setView([-1.5477778, 103.0927778], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Marker khusus untuk koordinat 1°32'52"S 103°05'34"E
    var specialIcon = L.divIcon({
        className: 'special-marker',
        html: '<div style="background-color: #dc3545; color: white; border-radius: 50%; width: 25px; height: 25px; border: 2px solid white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">★</div>',
        iconSize: [25, 25],
        iconAnchor: [12.5, 12.5]
    });

    var specialMarker = L.marker([-1.5477778, 103.0927778], {
        icon: specialIcon
    }).addTo(map)
    .bindPopup("<b>Lokasi Khusus</b><br>1°32'52\"S 103°05'34\"E<br><i>Koordinat yang diminta</i>");

    // Area mapping berdasarkan gambar peta - semua area dengan label L=
    var areas = [
        {
            name: "TONI",
            area: "L = 5.3 Ha",
            coords: [[-1.52, 103.04], [-1.52, 103.055], [-1.535, 103.055], [-1.535, 103.04]],
            center: [-1.5275, 103.0475]
        },
        {
            name: "FAUZI", 
            area: "L = 5.3 Ha",
            coords: [[-1.535, 103.055], [-1.535, 103.07], [-1.55, 103.07], [-1.55, 103.055]],
            center: [-1.5425, 103.0625]
        },
        {
            name: "SIANAK",
            area: "L = 12.99 Ha", 
            coords: [[-1.51, 103.08], [-1.51, 103.11], [-1.545, 103.11], [-1.545, 103.08]],
            center: [-1.5275, 103.095]
        },
        {
            name: "DAYAT",
            area: "Area Dayat",
            coords: [[-1.50, 103.09], [-1.50, 103.105], [-1.515, 103.105], [-1.515, 103.09]],
            center: [-1.5075, 103.0975]
        },
        {
            name: "BUJANG", 
            area: "Area Bujang",
            coords: [[-1.515, 103.105], [-1.515, 103.12], [-1.54, 103.12], [-1.54, 103.105]],
            center: [-1.5275, 103.1125]
        },
        {
            name: "HUSNAK",
            area: "L = 2.6 Ha",
            coords: [[-1.555, 103.085], [-1.555, 103.10], [-1.57, 103.10], [-1.57, 103.085]],
            center: [-1.5625, 103.0925]
        },
        {
            name: "NGADINO",
            area: "Area Ngadino", 
            coords: [[-1.57, 103.10], [-1.57, 103.115], [-1.585, 103.115], [-1.585, 103.10]],
            center: [-1.5775, 103.1075]
        },
        {
            name: "ADUN",
            area: "Area Adun",
            coords: [[-1.58, 103.08], [-1.58, 103.095], [-1.595, 103.095], [-1.595, 103.08]],
            center: [-1.5875, 103.0875]
        },
        {
            name: "GINTING",
            area: "L = 40.09 Ha",
            coords: [[-1.60, 103.03], [-1.60, 103.08], [-1.64, 103.08], [-1.64, 103.03]],
            center: [-1.62, 103.055]
        },
        {
            name: "JON ALI",
            area: "Area Jon Ali",
            coords: [[-1.59, 103.02], [-1.59, 103.035], [-1.605, 103.035], [-1.605, 103.02]],
            center: [-1.5975, 103.0275]
        },
        {
            name: "MUSA",
            area: "Area Musa",
            coords: [[-1.625, 103.065], [-1.625, 103.08], [-1.64, 103.08], [-1.64, 103.065]],
            center: [-1.6325, 103.0725]
        },
        {
            name: "SYAHRIL", 
            area: "Area Syahril",
            coords: [[-1.65, 103.04], [-1.65, 103.055], [-1.665, 103.055], [-1.665, 103.04]],
            center: [-1.6575, 103.0475]
        },
        {
            name: "SADAT",
            area: "Area Sadat",
            coords: [[-1.66, 103.055], [-1.66, 103.07], [-1.675, 103.07], [-1.675, 103.055]],
            center: [-1.6675, 103.0625]
        }
    ];

    // Menambahkan polygon area dan marker untuk setiap area
    areas.forEach(function(area) {
        // Membuat polygon dengan warna berbeda untuk area yang memiliki L=
        var hasLuasData = area.area.includes("L =");
        var polygon = L.polygon(area.coords, {
            color: hasLuasData ? '#2E8B57' : '#4169E1',
            fillColor: hasLuasData ? '#90EE90' : '#87CEEB',
            fillOpacity: 0.3,
            weight: 2
        }).addTo(map);

        // Menambahkan popup ke polygon
        polygon.bindPopup("<b>" + area.name + "</b><br>" + area.area);

        // Menambahkan marker label di tengah area jika ada data luas
        if (hasLuasData) {
            L.marker(area.center, {
                icon: L.divIcon({
                    className: 'area-label',
                    html: '<div style="background: rgba(255, 255, 255, 0.9); padding: 2px 5px; border: 1px solid #2E8B57; border-radius: 3px; font-size: 10px; font-weight: bold; box-shadow: 0 1px 3px rgba(0,0,0,0.3);">' + area.area + '</div>',
                    iconSize: [60, 20],
                    iconAnchor: [30, 10]
                })
            }).addTo(map);
        }
    });

    // Marker dari database lokasi sawit yang sudah ada
    @foreach($lokasi_sawit as $lokasi)
        L.marker([{{ $lokasi->latitude }}, {{ $lokasi->longitude }}], {
            icon: L.divIcon({
                className: 'database-marker',
                html: '<div style="background-color: #28a745; color: white; border-radius: 50%; width: 20px; height: 20px; border: 2px solid white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 10px;">DB</div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            })
        })
        .addTo(map)
        .bindPopup("<b>{{ $lokasi->nama_lokasi }}</b><br>{{ $lokasi->jenis_tanaman }}<br>{{ $lokasi->kondisi_tanaman }}<br><small>Data dari Database</small>");
    @endforeach

    // Menambahkan legend
    var legend = L.control({position: 'topright'});
    legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend');
        div.innerHTML = '<div style="background: white; padding: 10px; border-radius: 5px; box-shadow: 0 1px 5px rgba(0,0,0,0.2);">' +
            '<h6 style="margin: 0 0 5px 0;"><b>Legenda</b></h6>' +
            '<div><span style="color: #dc3545;">★</span> Koordinat Khusus (1°32\'52"S 103°05\'34"E)</div>' +
            '<div><span style="color: #2E8B57;">■</span> Area dengan data luas (L=)</div>' +
            '<div><span style="color: #4169E1;">■</span> Area tanpa data luas</div>' +
            '<div><span style="color: #28a745;">●</span> Data dari Database</div>' +
            '</div>';
        return div;
    };
    legend.addTo(map);
</script>

@endsection
