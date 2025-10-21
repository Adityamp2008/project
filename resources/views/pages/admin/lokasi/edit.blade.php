@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Lokasi</h3>

    <form action="{{ route('lokasi.update', $lokasi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Lokasi</label>
            <input type="text" name="nama" class="form-control" value="{{ $lokasi->nama }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi (Opsional)</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ $lokasi->deskripsi }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('lokasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
