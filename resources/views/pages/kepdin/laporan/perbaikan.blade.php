@extends('layouts.guest')
@section('title', 'Laporan Perbaikan')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Laporan Riwayat Perbaikan</h4>

    {{-- Export Buttons --}}
    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('laporan.perbaikan.pdf') }}" class="btn btn-danger btn-sm">
            <i class="bi bi-filetype-pdf"></i> Export PDF
        </a>
        <a href="{{ route('laporan.perbaikan.excel') }}" class="btn btn-success btn-sm">
            <i class="bi bi-filetype-xlsx"></i> Export Excel
        </a>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Aset</th>
                    <th>Kategori</th>
                    <th>Deskripsi Perbaikan</th>
                    <th>Biaya</th>
                    <th>Diperbaiki Oleh</th>
                    <th>Tanggal Perbaikan</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayats as $r)
                    @if($r->tanggal_perbaikan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $r->asset->nama ?? '-' }}</td>
                        <td>{{ $r->asset->kategori->nama ?? '-' }}</td>
                        <td>{{ $r->deskripsi_perbaikan ?? '-' }}</td>
                        <td>Rp {{ number_format($r->biaya, 0, ',', '.') }}</td>
                        <td>{{ $r->diperbaiki_oleh ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->tanggal_perbaikan)->format('d-m-Y') }}</td>
                        <td>{{ $r->tanggal_selesai ? \Carbon\Carbon::parse($r->tanggal_selesai)->format('d-m-Y') : '-' }}</td>
                        <td>
                            @if($r->status == 'proses')
                                <span class="badge bg-primary"><i class="bi bi-tools"></i> Sedang Diperbaiki</span>
                            @elseif($r->status == 'selesai')
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Selesai</span>
                            @else
                                <span class="badge bg-secondary">Belum Ada Status</span>
                            @endif
                        </td>
                    </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data perbaikan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
