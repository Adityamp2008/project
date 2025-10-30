@extends('layouts.app')

@section('title', 'Edit Aset')

@section('content')
<div class="container py-4">
    <h3 class="mb-3">Edit Aset</h3>

    <form action="{{ route('assets.update', $asset->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Aset</label>
            <input type="text" name="nama" id="nama" class="form-control" 
                   value="{{ old('nama', $asset->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori (Aset Tetap)</label>
            <select name="kategori_id" id="kategori_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoriAsetTetap as $kategori)
                    <option value="{{ $kategori->id }}" 
                        {{ $asset->kategori_id == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" name="lokasi" id="lokasi" class="form-control" 
                   value="{{ old('lokasi', $asset->lokasi) }}">
        </div>

        <div class="mb-3">
            <label for="tanggal_perolehan" class="form-label">Tanggal Perolehan</label>
            <input type="date" name="tanggal_perolehan" id="tanggal_perolehan" 
                   class="form-control" value="{{ old('tanggal_perolehan', $asset->tanggal_perolehan) }}">
        </div>

        <div class="mb-3">
            <label for="kondisi" class="form-label">Kondisi</label>
            <select name="kondisi" id="kondisi" class="form-select" required>
                <option value="baik" {{ $asset->kondisi == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="cukup" {{ $asset->kondisi == 'cukup' ? 'selected' : '' }}>Cukup</option>
                <option value="rusak" {{ $asset->kondisi == 'rusak' ? 'selected' : '' }}>Rusak</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $asset->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
