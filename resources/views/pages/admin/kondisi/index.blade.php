@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Kondisi Aset</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('kondisi.create') }}" class="btn btn-primary">+ Tambah Kondisi</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Kondisi</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kondisis as $index => $kondisi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kondisi->nama }}</td>
                    <td>{{ $kondisi->deskripsi ?? '-' }}</td>
                    <td>
                        <a href="{{ route('kondisi.edit', $kondisi->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('kondisi.destroy', $kondisi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kondisi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada data kondisi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
