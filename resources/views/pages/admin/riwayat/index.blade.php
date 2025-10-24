@extends('layouts.add')
@section('title', 'Daftar Riwayat Perbaikan')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Daftar Riwayat Perbaikan</h3>
        <a href="{{ route('riwayat.create') }}" class="btn btn-primary">
            + Tambah Riwayat
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Biaya</th>
                <th>Teknisi</th>
                <th>Tempat Data</th>
                <th>Nama Item</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat as $r)
                <tr>
                    <td>{{ $r->tanggal }}</td>
                    <td>{{ $r->deskripsi }}</td>
                    <td>Rp{{ number_format($r->biaya, 0, ',', '.') }}</td>
                    <td>{{ $r->teknisi }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $r->asset_type)) }}</td>
                    <td>
                        @if($r->asset_type === 'aset_tetap')
                            {{ $r->asset->nama_asset ?? '-' }}
                        @else
                            {{ $r->atk->nama_barang ?? '-' }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
