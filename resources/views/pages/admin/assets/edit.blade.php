@extends('layouts.add')
@section('title', 'Edit Aset')

@section('content')
<div class="container py-4">
    <h3>Edit Data Aset</h3>

    <form action="{{ route('assets.update', $asset->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Aset</label>
            <input type="text" name="nama" class="form-control" value="{{ $asset->nama }}" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="kategori" class="form-control" value="{{ $asset->kategori }}">
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="{{ $asset->lokasi }}">
        </div>

        <div class="mb-3">
            <label>Tanggal Perolehan</label>
            <input type="date" name="tanggal_perolehan" class="form-control" value="{{ $asset->tanggal_perolehan }}">
        </div>

        <div class="mb-3">
            <label>Kondisi</label>
            <select name="kondisi" class="form-control" required>
                <option value="Baik" {{ $asset->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Cukup" {{ $asset->kondisi == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                <option value="Rusak" {{ $asset->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ $asset->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
