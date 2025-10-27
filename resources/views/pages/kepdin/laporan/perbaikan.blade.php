@extends('layouts.guest')
@section('title', 'Laporan Perbaikan')

@section('content')
<div class="container">
    <h3 class="mb-4">Laporan Perbaikan</h3>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Dari Tanggal</label>
            <input type="date" name="dari" value="{{ request('dari') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Sampai Tanggal</label>
            <input type="date" name="sampai" value="{{ request('sampai') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Tempat Data</label>
            <select name="asset_type" class="form-select">
                <option value="">Semua</option>
                <option value="aset_tetap" {{ request('asset_type')=='aset_tetap'?'selected':'' }}>Aset Tetap</option>
                <option value="atk" {{ request('asset_type')=='atk'?'selected':'' }}>ATK</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Teknisi</label>
            <input type="text" name="teknisi" value="{{ request('teknisi') }}" class="form-control" placeholder="Nama teknisi">
        </div>

        <div class="col-12">
            <button class="btn btn-primary">Tampilkan</button>
            <a href="{{ route('laporan.perbaikan.pdf', request()->all()) }}" class="btn btn-danger">Export PDF</a>
            <a href="{{ route('laporan.perbaikan.excel', request()->all()) }}" class="btn btn-success">Export Excel</a>
        </div>
    </form>

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
            @forelse($riwayat as $r)
                <tr>
                    <td>{{ $r->tanggal }}</td>
                    <td>{{ $r->deskripsi }}</td>
                    <td>Rp{{ number_format($r->biaya, 0, ',', '.') }}</td>
                    <td>{{ $r->teknisi }}</td>
                    <td>{{ ucfirst(str_replace('_',' ',$r->asset_type)) }}</td>
                    <td>
                        @if($r->asset_type === 'aset_tetap')
                            {{ $r->asset->nama ?? '-' }}
                        @else
                            {{ $r->atk->name ?? '-' }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3 fw-bold">
        Total Biaya: Rp{{ number_format($total_biaya, 0, ',', '.') }}
    </div>
</div>
@endsection
