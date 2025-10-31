@extends('layouts.add')

@section('title', 'Edit Ruangan')

@section('content')
<div class="container py-4">
    <h3>Edit Ruangan</h3>
    <form action="{{ route('rooms.update', $room->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Ruangan</label>
            <input type="text" name="name" value="{{ $room->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="description" class="form-control" rows="3">{{ $room->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
