@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Lokasi Aset</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('lokasi.create') }}" class="btn btn-primary">+ Tambah Lokasi</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Lokasi</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lokasis as $index => $lokasi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $lokasi->nama }}</td>
                    <td>{{ $lokasi->deskripsi ?? '-' }}</td>
                    <td>
                        <a href="{{ route('lokasi.edit', $lokasi->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('lokasi.destroy', $lokasi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada data lokasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
