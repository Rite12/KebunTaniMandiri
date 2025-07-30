@extends('layouts.admin')

@section('page-title', '')

@section('main-content')

<!-- Title and Filter Form -->
<div class="d-flex align-items-center gap-2 mb-4">
    <h5 class="mb-0 d-flex align-items-center gap-2"
        style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.6rem; color: #212529;">
        <span>Pengeluaran Lainnya</span>
    </h5>
</div>

<!-- Filter Form -->
<div class="d-flex justify-content-between align-items-center gap-3 mb-3">
    <form method="GET" action="{{ route('kegiatan.index') }}" class="d-flex align-items-center gap-3">
        <!-- Filter Bulan -->
        <div class="input-group input-group-sm" style="max-width: 180px;">
            <span class="input-group-text bg-white">
                <i class="fas fa-calendar-month text-primary"></i>
            </span>
            <select name="bulan" class="form-control" required>
                <option value="">Pilih Bulan</option>
                @foreach(range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request('bulan') == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Input Tahun -->
        <div class="input-group input-group-sm" style="max-width: 120px;">
            <span class="input-group-text bg-white">
                <i class="fas fa-calendar-year text-primary"></i>
            </span>
            <input type="number" name="tahun" class="form-control" value="{{ request('tahun', date('Y')) }}" min="2020" max="{{ date('Y') }}" required>
        </div>

        <button type="submit" class="btn btn-sm btn-outline-info d-flex align-items-center gap-1">
            <i class="fas fa-search"></i> <span>Cari</span>
        </button>
    </form>
</div>

<!-- Tabel Data -->
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Kegiatan</th>
                        <th>Banyak</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kegiatans as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ number_format($item->banyak, 0) }}</td>
                            <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                <a href="{{ route('kegiatan.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>

                                <form action="{{ route('kegiatan.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
         <tr style="background-color: #d4edda;">
    <td colspan="3"><strong>Subtotal</strong></td>
    <td colspan="3"><strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
    <td></td>
</tr>



                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Tombol Kembali dan Tambah Rawat --}}
<div class="d-flex justify-content-end align-items-center gap-3 mt-4">
    <a href="{{ route('fitur.index') }}" class="btn btn-md btn-secondary text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="fas fa-arrow-left"></i> <span>Kembali</span>
    </a>

    @if(auth()->user()->hasRole('mandor'))
    <a href="{{ route('kegiatan.create') }}" class="btn btn-md btn-success text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
        <i class="fas fa-plus-circle"></i> <span>Tambah Pengeluaran</span>
    </a>
    @endif
</div>

@endsection

@section('scripts')
<!-- Flatpickr Script -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#tanggal", {
        dateFormat: "d/m/Y",
        altInput: true,
        altFormat: "d/m/Y",
        maxDate: "today",
        allowInput: true,
    });
</script>
@endsection
