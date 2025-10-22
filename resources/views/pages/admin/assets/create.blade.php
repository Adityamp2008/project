@extends('layouts.add')

@section('title', 'Tambah Aset')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Tambah Aset Baru</h3>

    <form action="{{ route('assets.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Aset</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input type="text" name="lokasi" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Perolehan</label>
            <input type="date" name="tanggal_perolehan" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="alert alert-info">
            Kondisi & kelayakan akan dihitung otomatis setelah disimpan.
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
