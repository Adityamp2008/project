@extends('layouts.add')

@section('title', 'Edit Aset')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Edit Aset: {{ $asset->nama }}</h3>

    <form action="{{ route('assets.update', $asset->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Aset</label>
            <input type="text" name="nama" class="form-control" value="{{ $asset->nama }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-control" value="{{ $asset->kategori }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="{{ $asset->lokasi }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Perolehan</label>
            <input type="date" name="tanggal_perolehan" class="form-control" value="{{ $asset->tanggal_perolehan }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ $asset->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Kondisi (otomatis)</label>
            <input type="text" class="form-control" value="{{ $asset->kondisi }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Kelayakan (otomatis)</label>
            <input type="text" class="form-control" value="{{ $asset->kelayakan }}" disabled>
        </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
