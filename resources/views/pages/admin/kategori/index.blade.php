@extends('layouts.add')

@section('title', 'Data Kategori')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Kategori</h3>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $kategori)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kategori->nama }}</td>
                <td>
                    <span class="badge {{ $kategori->tipe == 'aset_tetap' ? 'bg-primary' : 'bg-success' }}">
                        {{ strtoupper(str_replace('_',' ', $kategori->tipe)) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Belum ada kategori</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
