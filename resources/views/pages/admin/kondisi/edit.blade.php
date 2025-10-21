@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Kondisi</h3>

    <form action="{{ route('kondisi.update', $kondisi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Kondisi</label>
            <input type="text" name="nama" class="form-control" value="{{ $kondisi->nama }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi (Opsional)</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ $kondisi->deskripsi }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('kondisi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
