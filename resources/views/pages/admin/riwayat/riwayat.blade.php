@extends('layouts.add')

@section('content')
<div class="container">
    <h1>Riwayat Penggunaan & Perbaikan</h1>
    <a href="{{ route('riwayat.create') }}" class="btn btn-primary mb-3">Tambah Riwayat</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Aset</th>
                <th>Tipe</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayats as $riwayat)
                <tr>
                    <td>{{ $riwayat->id }}</td>
                    <td>{{ $riwayat->aset->nama ?? '-' }}</td>
                    <td>{{ ucfirst($riwayat->tipe) }}</td>
                    <td>{{ $riwayat->deskripsi }}</td>
                    <td>{{ $riwayat->tanggal->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('riwayat.show', $riwayat->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <form action="{{ route('riwayat.destroy', $riwayat->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Belum ada data riwayat.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
