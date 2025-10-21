@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Lokasi Baru</h3>

    <form action="{{ route('lokasi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Lokasi</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi (Opsional)</label>
            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('lokasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
