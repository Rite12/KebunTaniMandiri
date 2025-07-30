@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')

<!-- Container and Card -->
<div class="container" style="max-width: 650px;">
    <div class="card shadow-sm">
        <!-- Card Header -->
        <div class="card-header bg-dark text-white font-weight-bold text-center">
            Pengeluaran Lainnya
        </div>
        
        <!-- Form Section -->
        <div class="card-body">
            <form action="{{ route('kegiatan.store') }}" method="POST" id="kegiatanForm">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Kegiatan</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required placeholder="Masukkan nama kegiatan">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="banyak" class="form-label">Banyak</label>
                        <input type="number" name="banyak" id="banyak" class="form-control" value="{{ old('banyak') }}" required placeholder="Jumlah">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" value="{{ old('harga') }}" required placeholder="Harga">
                    </div>

                    <div class="col-md-12 mb-3">
    <label for="tanggal" class="form-label">Tanggal</label>
    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') ?? \Carbon\Carbon::today()->format('Y-m-d') }}" required>
</div>


                    <div class="col-md-12 mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Deskripsi kegiatan">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between gap-2 mt-4">
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-md btn-secondary text-white fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                            <i class="fas fa-arrow-left"></i> <span>Kembali</span>
                        </a>

                        <button type="submit" class="btn btn-md btn-success fw-semibold px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                            <i class="fas fa-save"></i> <span>Simpan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
