@extends('layouts.add')

@section('title', 'Data Aset')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Daftar Aset</h3>

    <a href="{{ route('assets.create') }}" class="btn btn-primary mb-3">+ Tambah Aset</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Tanggal Perolehan</th>
                <th>Umur (th)</th>
                <th>Kondisi</th>
                <th>Kelayakan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assets as $i => $asset)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $asset->nama }}</td>
                <td>{{ $asset->kategori ?? '-' }}</td>
                <td>{{ $asset->lokasi ?? '-' }}</td>
                <td>{{ $asset->tanggal_perolehan ?? '-' }}</td>
                <td>{{ $asset->umur_tahun ?? '-' }}</td>
                <td>{{ $asset->kondisi ?? '-' }}</td>
                <td>{{ $asset->kelayakan ?? '-' }}</td>
                <td>
                    <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Yakin ingin menghapus aset ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
