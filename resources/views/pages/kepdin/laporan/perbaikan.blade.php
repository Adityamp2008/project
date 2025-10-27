@extends('layouts.guest')
@section('title', 'Laporan Perbaikan')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Laporan Riwayat Perbaikan</h4>

    <div class="mb-3">
        <a href="{{ route('laporan.perbaikan.pdf') }}" class="btn btn-danger btn-sm">
            <i class="bi bi-filetype-pdf"></i> Export PDF
        </a>
        <a href="{{ route('laporan.perbaikan.excel') }}" class="btn btn-success btn-sm">
            <i class="bi bi-filetype-xlsx"></i> Export Excel
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Aset</th>
                    <th>Deskripsi Perbaikan</th>
                    <th>Biaya</th>
                    <th>Diperbaiki Oleh</th>
                    <th>Tanggal Perbaikan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayats as $key => $r)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $r->asset->nama ?? '-' }}</td>
                    <td>{{ $r->deskripsi_perbaikan }}</td>
                    <td>Rp {{ number_format($r->biaya, 0, ',', '.') }}</td>
                    <td>{{ $r->diperbaiki_oleh }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->tanggal_perbaikan)->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
