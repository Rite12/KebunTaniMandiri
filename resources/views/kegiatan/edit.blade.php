@extends('layouts.admin')

@section('main-content')
<h1 class="mb-4 font-weight-bold" style="font-family: 'Poppins', sans-serif;">✏️ Edit Kegiatan</h1>

<form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" id="kegiatanForm">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Nama Kegiatan</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $kegiatan->name) }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="banyak" class="form-label">Banyak</label>
            <input type="number" name="banyak" id="banyak" class="form-control" value="{{ old('banyak', $kegiatan->banyak) }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" value="{{ old('harga', $kegiatan->harga) }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="text" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $kegiatan->tanggal) }}" required>
        </div>

        <div class="col-md-12 mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" required>{{ old('keterangan', $kegiatan->keterangan) }}</textarea>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-success">Update Data</button>
        </div>
    </div>
</form>

@section('scripts')
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

@endsection
