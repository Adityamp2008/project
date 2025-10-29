@extends('layouts.add')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container py-4">
    <h3>Tambah Kategori</h3>
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipe</label>
            <select name="tipe" class="form-select" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="aset_tetap">Aset Tetap</option>
                <option value="atk">ATK</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
