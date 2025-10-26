@extends('layouts.app')

@section('title', 'Riwayat Perbaikan')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">🛠️ Riwayat Perbaikan Aset</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($riwayats->isEmpty())
        <div class="alert alert-secondary text-center">
            Belum ada data perbaikan aset.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Tanggal Perbaikan</th>
                        <th>Deskripsi</th>
                        <th>Biaya</th>
                        <th>Diperbaiki Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayats as $i => $r)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $r->asset->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->tanggal_perbaikan)->format('d-m-Y') }}</td>
                            <td class="text-start">{{ $r->deskripsi }}</td>
                            <td>Rp {{ number_format($r->biaya, 0, ',', '.') }}</td>
                            <td>{{ $r->diperbaiki_oleh ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
