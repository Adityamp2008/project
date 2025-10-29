@extends('layouts.add')

@section('title', 'Edit Kategori')

@section('content')
<div class="container py-4">
    <h3>Edit Kategori</h3>
    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama" value="{{ $kategori->nama }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipe</label>
            <select name="tipe" class="form-select" required>
                <option value="aset_tetap" {{ $kategori->tipe=='aset_tetap'?'selected':'' }}>Aset Tetap</option>
                <option value="atk" {{ $kategori->tipe=='atk'?'selected':'' }}>ATK</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
