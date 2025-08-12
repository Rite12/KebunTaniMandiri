@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')

@php
    use Carbon\Carbon;
    $selectedTanggal = request('tanggal', date('Y-m-d'));
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
.leaflet-popup-content-wrapper {
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}

.leaflet-popup-content {
    margin: 12px;
}

.area-label {
    background: none !important;
    border: none !important;
}

.database-marker {
    border: none !important;
    background: transparent !important;
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

/* Animation untuk label */
.area-label div {
    animation: labelPulse 2s infinite;
}

@keyframes labelPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Hover effect untuk polygon */
.leaflet-interactive:hover {
    cursor: pointer;
    filter: brightness(1.1);
}

/* Legenda styling */
.legend {
    background: rgba(255, 255, 255, 0.98) !important;
    backdrop-filter: blur(15px) !important;
    border-radius: 15px !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3) !important;
    border: 3px solid #28a745 !important;
    z-index: 1000 !important;
}

.legend h4 {
    background: linear-gradient(135deg, #28a745, #20c997) !important;
    color: white !important;
    margin: -10px -10px 10px -10px !important;
    padding: 12px !important;
    border-radius: 12px 12px 0 0 !important;
    text-align: center !important;
}

.legend-item {
    padding: 6px 0 !important;
    border-bottom: 1px solid #eee !important;
    display: flex !important;
    align-items: center !important;
}

.legend-item:last-child {
    border-bottom: none !important;
}

/* Info box styling */
.info-box {
    border: none !important;
    background: transparent !important;
}

.leaflet-top.leaflet-left {
    margin-top: 10px !important;
    margin-left: 10px !important;
}

/* Scale control styling */
.leaflet-control-scale {
    background: rgba(255,255,255,0.9) !important;
    border-radius: 8px !important;
    border: 2px solid #28a745 !important;
    font-weight: bold !important;
}

/* Boundary label styling */
.boundary-label {
    border: none !important;
    background: transparent !important;
}

/* Leaflet control positioning */
.leaflet-bottom.leaflet-right {
    margin-bottom: 20px !important;
    margin-right: 20px !important;
}

/* Animation untuk legend */
.legend {
    animation: legendFadeIn 1s ease-in-out;
}

@keyframes legendFadeIn {
    0% { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    100% { 
        opacity: 1; 
        transform: translateY(0); 
    }
}
</style>

<!-- Peta Lokasi Sawit -->
<div id="map" style="height: 400px; border: 1px solid #ddd; margin-bottom: 20px;"></div>

<!-- Toggle Button for Table -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0"><i class="fas fa-table text-primary"></i> Data Lokasi Sawit</h5>
    <button id="toggleTableBtn" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-eye-slash"></i> <span id="toggleText">Sembunyikan Tabel</span>
    </button>
</div>

<!-- Tabel Lokasi Sawit -->
<div id="dataTable" class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            @if($lokasi_sawit->count() > 0)
            <table class="table table-bordered table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Lokasi</th>
                        <th>🌿 Luas Lahan Sawit (ha)</th>
                        <th>Jenis Tanaman</th>
                        <th>Status</th>
                        <th>Koordinat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lokasi_sawit as $lokasi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $lokasi->nama_lokasi }}</strong>
                            @if($lokasi->luas_lahan > 0)
                                <br><small class="badge badge-success">🌿 Lahan Sawit</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-success" style="font-size: 14px;">
                                L = {{ $lokasi->luas_lahan }} Ha
                            </span>
                        </td>
                        <td>
                            <i class="fas fa-seedling text-success"></i> {{ $lokasi->jenis_tanaman }}
                        </td>
                        <td>
                            @if($lokasi->kondisi_tanaman == 'Produktif')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> {{ $lokasi->kondisi_tanaman }}
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $lokasi->kondisi_tanaman }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <small>
                                <strong>Lat:</strong> {{ $lokasi->latitude }}<br>
                                <strong>Lng:</strong> {{ $lokasi->longitude }}
                            </small>
                        </td>
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
    // Inisialisasi peta dengan koordinat tengah yang disesuaikan berdasarkan gambar: 1°31'15"S 103°06'51"E
    var map = L.map('map', {
        center: [-1.520833, 103.114167],  // 1°31'15"S 103°06'51"E
        zoom: 14,
        minZoom: 12,
        maxZoom: 18,
        zoomControl: true
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors | 🌿 Kebun Sawit Manis Madu',
        maxZoom: 18,
    }).addTo(map);

    // Tambahkan kontrol skala
    L.control.scale({
        position: 'bottomleft',
        metric: true,
        imperial: false
    }).addTo(map);

    // Info box untuk menampilkan koordinat mouse
    var infoBox = L.control({position: 'topleft'});
    infoBox.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info-box');
        div.innerHTML = `
            <div id="coordinates-display" style="background: rgba(255,255,255,0.95); 
                                                  padding: 8px 12px; 
                                                  border-radius: 8px; 
                                                  box-shadow: 0 2px 8px rgba(0,0,0,0.2); 
                                                  font-family: monospace; 
                                                  font-size: 11px;
                                                  border: 2px solid #007bff;
                                                  backdrop-filter: blur(5px);">
                <div style="font-weight: bold; color: #007bff; margin-bottom: 2px;">📍 KOORDINAT MOUSE</div>
                <div id="mouse-coords" style="color: #495057;">Hover di peta...</div>
            </div>
        `;
        return div;
    };
    infoBox.addTo(map);

    // Event listener untuk menampilkan koordinat mouse
    map.on('mousemove', function(e) {
        var coords = e.latlng;
        document.getElementById('mouse-coords').innerHTML = 
            'Lat: ' + coords.lat.toFixed(6) + '<br>Lng: ' + coords.lng.toFixed(6);
    });

    // Koordinat batas peta berdasarkan gambar yang akurat (E103°03'00" - E103°05'48" dan S1°32'00" - S1°35'06")
    var mapBounds = {
        north: -1.533333,  // S1°32'00" (bagian utara)
        south: -1.585000,  // S1°35'06" (bagian selatan)  
        west: 103.050000,  // E103°03'00" (bagian barat)
        east: 103.096667   // E103°05'48" (bagian timur)
    };

    // Menggambar batas keseluruhan area peta dengan styling yang lebih baik
    var outerBounds = L.rectangle([
        [mapBounds.south, mapBounds.west],
        [mapBounds.north, mapBounds.east]
    ], {
        color: '#2c3e50',
        weight: 4,
        fillOpacity: 0.05,
        fillColor: '#ecf0f1',
        dashArray: '10, 5'
    }).addTo(map);

    // Menambahkan label untuk batas peta
    var boundaryIcon = L.divIcon({
        className: 'boundary-label',
        html: `<div style="background: rgba(44, 62, 80, 0.9); 
                          color: white; 
                          padding: 6px 12px; 
                          border-radius: 20px; 
                          font-size: 11px; 
                          font-weight: bold;
                          box-shadow: 0 2px 6px rgba(0,0,0,0.3);
                          white-space: nowrap;">
                  📍 BATAS AREA PEMETAAN
               </div>`,
        iconSize: [150, 25],
        iconAnchor: [75, 12]
    });
    
    L.marker([mapBounds.north - 0.005, (mapBounds.west + mapBounds.east) / 2], {
        icon: boundaryIcon
    }).addTo(map);

    // Marker khusus untuk titik tengah pada koordinat yang diminta sesuai gambar
    var centerIcon = L.divIcon({
        className: 'special-marker',
        html: '<div style="background-color: #dc3545; color: white; border-radius: 50%; width: 35px; height: 35px; border: 3px solid white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px; box-shadow: 0 3px 8px rgba(0,0,0,0.6);">★</div>',
        iconSize: [35, 35],
        iconAnchor: [17.5, 17.5]
    });

    var centerMarker = L.marker([-1.520833, 103.114167], {
        icon: centerIcon
    }).addTo(map)
    .bindPopup("<b>TITIK TENGAH PETA</b><br>1°31'15\"S 103°06'51\"E<br><i>Koordinat pusat polygon</i>");

    // Hanya area dengan label "L=" sesuai gambar referensi
    var areas = [
        {
            name: "LAHAN SAWIT MANIS MADU", 
            area: "LAHAN SAWIT MANIS MADU",
            areaSize: "L = 5.5 Ha",
            areaType: "Lahan Sawit Manis Madu",
            coords: [
                [-1.533333, 103.058333],  // Kiri atas
                [-1.533333, 103.065000],  // Kanan atas
                [-1.540833, 103.070000],  // Kanan tengah
                [-1.545000, 103.068333],  // Kanan bawah
                [-1.546667, 103.065000],  // Sudut bawah
                [-1.545000, 103.061667],  // Bawah kiri
                [-1.541667, 103.058333],  // Kiri bawah
                [-1.533333, 103.058333]   // Kembali ke awal
            ],
            center: [-1.540000, 103.063333],
            color: '#4CAF50',
            strokeColor: '#2E7D32',
            strokeWidth: 3,
            hasArea: true
        },
        {
            name: "LAHAN SAWIT MANIS MADU", 
            area: "LAHAN SAWIT MANIS MADU",
            areaSize: "L = 12.99 Ha",
            areaType: "Lahan Sawit Manis Madu",
            coords: [
                [-1.540000, 103.088333],  // Kiri atas
                [-1.540000, 103.096667],  // Kanan atas
                [-1.555000, 103.093333],  // Kanan tengah
                [-1.566667, 103.093333],  // Kanan bawah
                [-1.566667, 103.083333],  // Sudut bawah
                [-1.565000, 103.078333],  // Bawah kanan
                [-1.561667, 103.076667],  // Bawah tengah
                [-1.556667, 103.076667],  // Bawah kiri
                [-1.551667, 103.077500],  // Kiri bawah
                [-1.546667, 103.078333],  // Kiri tengah
                [-1.543333, 103.078333],  // Kiri atas
                [-1.540000, 103.088333]   // Kembali ke awal
            ],
            center: [-1.553333, 103.086667],
            color: '#9C27B0',
            strokeColor: '#6A1B9A',
            strokeWidth: 3,
            hasArea: true
        },
        {
            name: "LAHAN SAWIT MANIS MADU",
            area: "LAHAN SAWIT MANIS MADU",
            areaSize: "L = 2.6 Ha",
            areaType: "Lahan Sawit Manis Madu",
            coords: [
                [-1.548333, 103.081667],  // Kiri atas
                [-1.548333, 103.090000],  // Kanan atas
                [-1.556667, 103.088333],  // Kanan tengah
                [-1.560000, 103.085000],  // Kanan bawah
                [-1.560000, 103.081667],  // Sudut bawah
                [-1.556667, 103.079167],  // Bawah kiri
                [-1.552500, 103.080000],  // Kiri bawah
                [-1.550000, 103.081667],  // Kiri tengah
                [-1.548333, 103.081667]   // Kembali ke awal
            ],
            center: [-1.554167, 103.085000],
            color: '#2196F3',
            strokeColor: '#1565C0',
            strokeWidth: 3,
            hasArea: true
        },
        {
            name: "LAHAN SAWIT MANIS MADU",
            area: "LAHAN SAWIT MANIS MADU",
            areaSize: "L = 40.09 Ha",
            areaType: "Lahan Sawit Manis Madu",
            coords: [
                [-1.543333, 103.050000],  // Kiri atas
                [-1.543333, 103.075000],  // Tengah atas
                [-1.550000, 103.075000],  // Kanan atas
                [-1.556667, 103.073333],  // Sudut kanan atas
                [-1.563333, 103.075000],  // Kanan tengah
                [-1.570000, 103.076667],  // Kanan bawah
                [-1.576667, 103.075000],  // Sudut kanan bawah
                [-1.583333, 103.071667],  // Bawah kanan
                [-1.585000, 103.065000],  // Bawah tengah
                [-1.583333, 103.058333],  // Bawah kiri
                [-1.580000, 103.053333],  // Sudut bawah kiri
                [-1.575000, 103.050000],  // Kiri bawah
                [-1.570000, 103.048333],  // Kiri tengah bawah
                [-1.565000, 103.048333],  // Kiri tengah
                [-1.560000, 103.049167],  // Sudut kiri tengah
                [-1.555000, 103.050000],  // Kiri tengah atas
                [-1.550000, 103.051667],  // Kiri atas tengah
                [-1.546667, 103.050000],  // Sudut kiri atas
                [-1.543333, 103.050000]   // Kembali ke awal
            ],
            center: [-1.564167, 103.061667],
            color: '#4CAF50',
            strokeColor: '#2E7D32',
            strokeWidth: 3,
            hasArea: true
        }
    ];

    // Area khusus untuk label "L=" dengan polygon terpisah yang lebih akurat - hanya untuk 4 area yang ada di gambar
    var labelAreas = [
        {
            label: "L = 5.5 Ha",
            coords: [
                [-1.537000, 103.060500],  // LAHAN SAWIT MANIS MADU label area
                [-1.537000, 103.063500],  
                [-1.540000, 103.063500],  
                [-1.540000, 103.060500],  
                [-1.537000, 103.060500]   
            ],
            center: [-1.538500, 103.062000],
            color: '#E8F5E8',
            strokeColor: '#2E7D32',
            strokeWidth: 2,
            parentArea: "LAHAN SAWIT MANIS MADU"
        },
        {
            label: "L = 12.99 Ha",
            coords: [
                [-1.550000, 103.084000],  // LAHAN SAWIT MANIS MADU label area
                [-1.550000, 103.090000],  
                [-1.555000, 103.090000],  
                [-1.555000, 103.084000],  
                [-1.550000, 103.084000]   
            ],
            center: [-1.552500, 103.087000],
            color: '#E8F5E8',
            strokeColor: '#6A1B9A',
            strokeWidth: 2,
            parentArea: "LAHAN SAWIT MANIS MADU"
        },
        {
            label: "L = 2.6 Ha",
            coords: [
                [-1.551000, 103.083000],  // LAHAN SAWIT MANIS MADU label area
                [-1.551000, 103.085500],  
                [-1.554000, 103.085500],  
                [-1.554000, 103.083000],  
                [-1.551000, 103.083000]   
            ],
            center: [-1.552500, 103.084250],
            color: '#E8F5E8',
            strokeColor: '#1565C0',
            strokeWidth: 2,
            parentArea: "LAHAN SAWIT MANIS MADU"
        },
        {
            label: "L = 40.09 Ha",
            coords: [
                [-1.560000, 103.058000],  // LAHAN SAWIT MANIS MADU label area  
                [-1.560000, 103.065000],  
                [-1.568000, 103.065000],  
                [-1.568000, 103.058000],  
                [-1.560000, 103.058000]   
            ],
            center: [-1.564000, 103.061500],
            color: '#E8F5E8',
            strokeColor: '#2E7D32',
            strokeWidth: 2,
            parentArea: "LAHAN SAWIT MANIS MADU"
        }
    ];

    // Menambahkan polygon area dan marker untuk setiap area dengan styling yang jelas dan rapi
    areas.forEach(function(area) {
        // Membuat polygon dengan border yang jelas dan warna yang kontras
        var polygon = L.polygon(area.coords, {
            color: area.strokeColor || area.color,
            weight: area.strokeWidth || 3,
            opacity: 1,
            fillColor: area.color,
            fillOpacity: 0.5,
            dashArray: area.hasArea ? null : '8, 5' // Garis putus-putus untuk area tanpa data luas
        }).addTo(map);

        // Menambahkan efek hover untuk interaktivitas yang lebih baik
        polygon.on('mouseover', function (e) {
            this.setStyle({
                weight: (area.strokeWidth || 3) + 2,
                fillOpacity: 0.7,
                color: '#000000'
            });
        });

        polygon.on('mouseout', function (e) {
            this.setStyle({
                weight: area.strokeWidth || 3,
                fillOpacity: 0.5,
                color: area.strokeColor || area.color
            });
        });

        // Menambahkan popup yang informatif dengan label "LAHAN SAWIT MANIS MADU"
        var popupContent = `
            <div style="min-width: 250px; font-family: 'Arial', sans-serif; text-align: center;">
                <div style="background: linear-gradient(135deg, ${area.color}33, ${area.color}66); 
                           padding: 12px; margin: -12px -12px 12px -12px; 
                           border-radius: 12px 12px 0 0; border-bottom: 3px solid ${area.color};">
                    <h4 style="margin: 0; color: #1a1a1a; font-size: 18px; font-weight: bold;">
                        📍 ${area.name}
                    </h4>
                </div>
        `;
        
        if (area.hasArea) {
            popupContent += `
                <div style="background: linear-gradient(135deg, #e8f5e8, #d4edda); 
                           padding: 12px; border-radius: 8px; margin: 8px 0; 
                           border: 2px solid #28a745; box-shadow: 0 2px 4px rgba(40,167,69,0.2);">
                    <div style="font-weight: bold; color: #155724; font-size: 14px; margin-bottom: 4px;">
                        🌿 ${area.area}
                    </div>
                    <div style="color: #28a745; font-size: 16px; font-weight: bold;">
                        ${area.areaSize}
                    </div>
                    <div style="background: #28a745; color: white; padding: 4px 8px; 
                               border-radius: 15px; margin-top: 6px; font-size: 11px;">
                        ✅ Data Luas Tersedia
                    </div>
                </div>
            `;
        } else {
            popupContent += `
                <div style="background: #f8f9fa; padding: 12px; border-radius: 8px; 
                           margin: 8px 0; border: 2px solid #6c757d;">
                    <div style="color: #495057; font-size: 14px; font-weight: bold;">
                        ${area.area}
                    </div>
                    <div style="background: #ffc107; color: #212529; padding: 4px 8px; 
                               border-radius: 15px; margin-top: 6px; font-size: 11px;">
                        ⚠️ Belum Ada Data Luas
                    </div>
                </div>
            `;
        }
        
        popupContent += `
                <div style="margin-top: 10px; padding-top: 8px; border-top: 2px solid #eee; 
                           font-size: 12px; color: #6c757d;">
                    📐 Koordinat: ${area.center[0].toFixed(6)}, ${area.center[1].toFixed(6)}
                </div>
            </div>
        `;
        
        polygon.bindPopup(popupContent, {
            maxWidth: 300,
            className: 'custom-popup'
        });

        // Menambahkan label di tengah area dengan label "LAHAN SAWIT MANIS MADU" untuk area yang memiliki data luas
        if (area.hasArea) {
            var labelIcon = L.divIcon({
                className: 'area-label',
                html: `
                    <div style="background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(248,249,250,0.95)); 
                               border: 3px solid ${area.color}; 
                               border-radius: 15px; 
                               padding: 8px 12px; 
                               font-weight: bold; 
                               text-align: center; 
                               box-shadow: 0 4px 8px rgba(0,0,0,0.3); 
                               white-space: nowrap; 
                               min-width: 120px;
                               backdrop-filter: blur(5px);">
                        <div style="font-size: 9px; color: #28a745; margin-bottom: 2px; font-weight: bold;">
                            🌿 LAHAN SAWIT MANIS MADU
                        </div>
                        <div style="font-size: 13px; font-weight: bold; color: ${area.color}; margin: 2px 0;">
                            LAHAN SAWIT MANIS MADU
                        </div>
                        <div style="font-size: 11px; color: #28a745; font-weight: bold; margin-top: 2px;">
                            ${area.areaSize}
                        </div>
                    </div>
                `,
                iconSize: [130, 60],
                iconAnchor: [65, 30]
            });
            
            L.marker(area.center, {
                icon: labelIcon
            }).addTo(map);
        } else {
            // Label sederhana untuk area tanpa data luas
            var simpleLabelIcon = L.divIcon({
                className: 'area-label',
                html: `
                    <div style="background: rgba(255,255,255,0.9); 
                               border: 2px solid ${area.color}; 
                               border-radius: 8px; 
                               padding: 6px 10px; 
                               font-weight: bold; 
                               text-align: center; 
                               box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                               backdrop-filter: blur(3px);">
                        <div style="font-size: 12px; color: ${area.color}; font-weight: bold;">
                            ${area.name}
                        </div>
                        <div style="font-size: 9px; color: #666; margin-top: 1px;">
                            Area Lain
                        </div>
                    </div>
                `,
                iconSize: [80, 35],
                iconAnchor: [40, 17]
            });
            
            L.marker(area.center, {
                icon: simpleLabelIcon
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

    // Menambahkan legenda peta yang informatif dan menarik
    var legend = L.control({position: 'bottomright'});
    legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend');
        div.innerHTML = `
            <div style="background: linear-gradient(135deg, rgba(255,255,255,0.98), rgba(248,249,250,0.95)); 
                        padding: 18px; 
                        border-radius: 15px; 
                        box-shadow: 0 6px 20px rgba(0,0,0,0.25); 
                        font-family: 'Arial', sans-serif; 
                        min-width: 280px;
                        border: 3px solid #28a745;
                        backdrop-filter: blur(10px);">
                
                <div style="background: linear-gradient(135deg, #28a745, #20c997); 
                           color: white; 
                           margin: -18px -18px 15px -18px; 
                           padding: 12px 18px; 
                           border-radius: 12px 12px 0 0; 
                           text-align: center;
                           font-weight: bold;
                           font-size: 14px;">
                    🗺️ LEGENDA PETA SAWIT MANIS MADU
                </div>
                
                <div style="background: linear-gradient(135deg, #e8f5e8, #d4edda); 
                           padding: 10px; 
                           border-radius: 8px; 
                           border-left: 4px solid #28a745; 
                           margin-bottom: 10px;">
                    <div style="display: flex; align-items: center; margin-bottom: 6px;">
                        <span style="color: #28a745; font-size: 16px; margin-right: 8px;">🌿</span> 
                        <span style="font-weight: bold; color: #155724; font-size: 13px;">LAHAN SAWIT MANIS MADU</span>
                    </div>
                    <div style="font-size: 10px; color: #155724; margin-left: 24px; line-height: 1.4;">
                        ✅ Area dengan Label "L=" (Data Luas Tersedia)<br>
                        📊 4 Area - Total: 61.18 Ha (49.07%)
                    </div>
                </div>
                
                <div style="background: #e3f2fd; 
                           padding: 8px; 
                           border-radius: 8px; 
                           border-left: 4px solid #2196f3; 
                           margin-bottom: 10px;">
                    <div style="display: flex; align-items: center;">
                        <span style="color: #1976d2; font-size: 14px; margin-right: 8px;">▢</span> 
                        <span style="font-size: 11px; color: #0d47a1; font-weight: bold;">BATAS AREA PEMETAAN</span>
                    </div>
                    <div style="font-size: 9px; color: #1976d2; margin-left: 22px;">
                        Koordinat: 1°32'00"S - 1°35'06"S<br>
                        103°03'00"E - 103°05'48"E
                    </div>
                </div>
                
                <hr style="margin: 12px 0; border: none; border-top: 2px solid #e9ecef;">
                
                <div style="text-align: center;">
                    <div style="font-weight: bold; color: #28a745; font-size: 12px; margin-bottom: 2px;">
                        🏆 KEBUN SAWIT MANIS MADU
                    </div>
                    <div style="font-size: 10px; color: #6c757d; line-height: 1.3;">
                        📊 Total 14 Area | 📏 124.68 Ha<br>
                        🌿 Lahan Sawit Premium | 🗓️ ${new Date().getFullYear()}
                    </div>
                </div>
            </div>
        `;
        return div;
    };
    legend.addTo(map);

    // Menambahkan kontrol zoom yang responsif dengan fokus area
    map.fitBounds([
        [mapBounds.south, mapBounds.west],
        [mapBounds.north, mapBounds.east]
    ], {
        padding: [30, 30]
    });

    // Table Toggle Functionality
    document.getElementById('toggleTableBtn').addEventListener('click', function() {
        const dataTable = document.getElementById('dataTable');
        const toggleBtn = this;
        const toggleText = document.getElementById('toggleText');
        const icon = toggleBtn.querySelector('i');
        
        if (dataTable.style.display === 'none') {
            // Show table
            dataTable.style.display = 'block';
            toggleText.textContent = 'Sembunyikan Tabel';
            icon.className = 'fas fa-eye-slash';
            toggleBtn.classList.remove('btn-outline-success');
            toggleBtn.classList.add('btn-outline-primary');
            
            // Resize map back to normal
            document.getElementById('map').style.height = '400px';
        } else {
            // Hide table
            dataTable.style.display = 'none';
            toggleText.textContent = 'Tampilkan Tabel';
            icon.className = 'fas fa-eye';
            toggleBtn.classList.remove('btn-outline-primary');
            toggleBtn.classList.add('btn-outline-success');
            
            // Expand map for better visibility
            document.getElementById('map').style.height = '600px';
        }
        
        // Trigger map resize after DOM changes
        setTimeout(function() {
            map.invalidateSize();
        }, 300);
    });
    
    // Add smooth transition for table
    document.getElementById('dataTable').style.transition = 'all 0.3s ease-in-out';
    document.getElementById('map').style.transition = 'height 0.3s ease-in-out';
</script>

@endsection
