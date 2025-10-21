@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Riwayat</h2>
    <a href="{{ route('riwayat.create') }}" class="btn btn-primary mb-3">Tambah Riwayat</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Asset</th>
                <th>Tipe</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayats as $index => $riwayat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $riwayat->assets->nama_asset ?? '-' }}</td>
                <td>{{ ucfirst($riwayat->tipe) }}</td>
                <td>{{ $riwayat->deskripsi }}</td>
                <td>{{ $riwayat->tanggal }}</td>
                <td>
                    <a href="{{ route('riwayat.show', $riwayat->id) }}" class="btn btn-info btn-sm">Lihat</a>
                    <a href="{{ route('riwayat.edit', $riwayat->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('riwayat.destroy', $riwayat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
