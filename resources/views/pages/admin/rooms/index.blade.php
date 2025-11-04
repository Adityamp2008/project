@extends('layouts.add')

@section('title', 'Manajemen Ruangan')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Ruangan</h3>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">+ Tambah Ruangan</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama Ruangan</th>
                <th>Keterangan</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rooms as $room)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $room->name }}</td>
                    <td>{{ $room->description ?? '-' }}</td>
                    <td>
                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus ruangan ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada ruangan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $rooms->links() }}
</div>
@endsection
