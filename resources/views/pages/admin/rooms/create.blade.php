@extends('layouts.add')

@section('title', 'Tambah Ruangan')

@section('content')
<div class="container py-4">
    <h3>Tambah Ruangan</h3>
    <form action="{{ route('rooms.store') }}" method="POST" class="mt-3">
        @csrf
        <div class="mb-3">
            <label>Nama Ruangan</label>
            <input type="text" name="name" class="form-control" required placeholder="Contoh: Ruang 1 / Lab RPL">
        </div>

        <div class="mb-3">
            <label>Keterangan (opsional)</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
