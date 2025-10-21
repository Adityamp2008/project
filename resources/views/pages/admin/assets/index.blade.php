@extends('layouts.add')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Aset Tetap</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('assets.create') }}" class="btn btn-primary">+ Tambah Aset</a>
        <a href="{{ route('kelayakan-assets.index') }}" class="btn btn-secondary">Lihat Kelayakan</a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>No</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Kondisi</th>
                <th>Lokasi</th>
                <th>Tanggal Perolehan</th>
                <th>Umur (tahun)</th>
                <th>Status Kelayakan</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assets as $i => $item)
                @php
                    $umur = $item->umur_tahun ?? ($item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->diffInYears(now()) : 0);
                    $kondisi = strtolower($item->kondisi ?? '');
                    if ($kondisi === 'baik' && $umur <= 5) {
                        $status = 'Layak'; $badge='success';
                    } elseif ($kondisi === 'rusak ringan' || ($umur > 5 && $umur <= 8)) {
                        $status = 'Kurang Layak'; $badge='warning';
                    } elseif ($kondisi === 'rusak berat' || $umur > 8) {
                        $status = 'Tidak Layak'; $badge='danger';
                    } else {
                        $status = 'Tidak Diketahui'; $badge='secondary';
                    }
                @endphp
                <tr><?php $no = 1; ?>
                <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kategori ?? '-' }}</td>
                    <td>{{ $item->kondisi ?? '-' }}</td>
                    <td>{{ $item->lokasi ?? '-' }}</td>
                    <td>{{ $item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->translatedFormat('d M Y') : '-' }}</td>
                    <td class="text-center">{{ $umur }}</td>
                    <td class="text-center"><span class="badge bg-{{ $badge }}">{{ $status }}</span></td>
                    <td>{{ $item->description ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('assets.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('assets.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="10" class="text-center text-muted">Belum ada data aset.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
