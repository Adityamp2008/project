@extends('layouts.add')
@section('title', 'Edit Aset')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Edit Data Aset</h3>

    <form action="{{ route('assets.update', $asset->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Aset --}}
        <div class="mb-3">
            <label class="form-label">Nama Aset</label>
            <input 
                type="text" 
                name="nama" 
                class="form-control @error('nama') is-invalid @enderror" 
                value="{{ old('nama', $asset->nama) }}" 
                required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input 
                type="text" 
                name="kategori" 
                class="form-control @error('kategori') is-invalid @enderror" 
                value="{{ old('kategori', $asset->kategori) }}">
            @error('kategori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Lokasi --}}
        <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input 
                type="text" 
                name="lokasi" 
                class="form-control @error('lokasi') is-invalid @enderror" 
                value="{{ old('lokasi', $asset->lokasi) }}">
            @error('lokasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Perolehan --}}
        <div class="mb-3">
            <label class="form-label">Tanggal Perolehan</label>
            <input 
                type="date" 
                name="tanggal_perolehan" 
                class="form-control" 
                value="{{ old('tanggal_perolehan', is_object($asset->tanggal_perolehan) ? $asset->tanggal_perolehan->format('Y-m-d') : $asset->tanggal_perolehan) }}">
            @error('tanggal_perolehan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kondisi --}}
        <div class="mb-3">
            <label class="form-label">Kondisi</label>
            <select 
                name="kondisi" 
                class="form-select @error('kondisi') is-invalid @enderror" 
                required>
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baik" {{ old('kondisi', $asset->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Cukup" {{ old('kondisi', $asset->kondisi) == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                <option value="Rusak" {{ old('kondisi', $asset->kondisi) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
            </select>
            @error('kondisi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea 
                name="description" 
                rows="3" 
                class="form-control @error('description') is-invalid @enderror">{{ old('description', $asset->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('assets.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Perbarui
            </button>
        </div>
    </form>
</div>
@endsection
