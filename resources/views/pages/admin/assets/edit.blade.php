@extends('layouts.add')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Aset</h3>

    <form action="{{ route('assets.update', $asset->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Nama Aset</label><input type="text" name="nama" class="form-control" value="{{ old('nama', $asset->nama) }}" required></div>
        <div class="mb-3"><label class="form-label">Kategori</label><input type="text" name="kategori" class="form-control" value="{{ old('kategori', $asset->kategori) }}"></div>
        <div class="mb-3"><label class="form-label">Kondisi</label>
            <select name="kondisi" class="form-select">
                <option value="Baik" {{ old('kondisi', $asset->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Rusak Ringan" {{ old('kondisi', $asset->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="Rusak Berat" {{ old('kondisi', $asset->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Lokasi</label><input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $asset->lokasi) }}"></div>
        <div class="mb-3"><label class="form-label">Tanggal Perolehan</label><input type="date" name="tanggal_perolehan" class="form-control" value="{{ old('tanggal_perolehan', $asset->tanggal_perolehan ? \Carbon\Carbon::parse($asset->tanggal_perolehan)->format('Y-m-d') : '') }}"></div>
        <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3">{{ old('description', $asset->description) }}</textarea></div>
        <button class="btn btn-primary">Simpan Perubahan</button>
        <a class="btn btn-secondary" href="{{ route('assets.index') }}">Batal</a>
    </form>
</div>
@endsection
