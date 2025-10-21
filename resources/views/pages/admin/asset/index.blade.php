@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Aset Tetap</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('assets.create') }}" class="btn btn-primary">+ Tambah Aset</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Kondisi</th>
                <th>Lokasi</th>
                <th>Tanggal Perolehan</th>
                <th>Status Kelayakan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assets as $index => $item)
                @php
                    // Hitung kelayakan otomatis
                    $usia = now()->diffInYears($item->tanggal_perolehan);
                    $frekuensi_perbaikan = $item->riwayat->count() ?? 0;

                    if ($item->kondisi->nama == 'Rusak Berat' || $usia > 5 || $frekuensi_perbaikan > 3) {
                        $status = 'Tidak Layak';
                        $badge = 'danger';
                    } else {
                        $status = 'Layak';
                        $badge = 'success';
                    }
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                    <td>{{ $item->kondisi->nama ?? '-' }}</td>
                    <td>{{ $item->lokasi->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d M Y') }}</td>
                    <td><span class="badge bg-{{ $badge }}">{{ $status }}</span></td>
                    <td>
                        <a href="{{ route('assets.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('assets.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada data aset.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
