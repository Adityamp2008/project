@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Data Kelayakan Aset Tetap</h3>

    <div class="mb-3">
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">← Kembali ke daftar aset</a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>No</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Kondisi</th>
                <th>Usia (tahun)</th>
                <th>Status Kelayakan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kelayakanassets as $i => $item)
                <tr>
                    <?php $no = 1; ?>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $item->asset->nama ?? '-' }}</td>
                    <td>{{ $item->asset->kategori ?? '-' }}</td>
                    <td>{{ $item->asset->kondisi ?? '-' }}</td>
                    <td class="text-center">{{ $item->asset->umur_tahun ?? 0 }}</td>
                    <td class="text-center">
                        <span class="badge bg-{{ $item->status_kelayakan == 'Layak' ? 'success' : ($item->status_kelayakan == 'Kurang Layak' ? 'warning' : 'danger') }}">
                            {{ $item->status_kelayakan }}
                        </span>
                    </td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted">Belum ada data kelayakan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
