@extends('layouts.add')
@section('title','Laporan Inventaris')

@section('content')
<div class="container">
    <h3 class="mb-4">Laporan Inventaris</h3>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Jenis</label>
            <select name="asset_type" class="form-select">
                <option value="">Semua</option>
                <option value="aset_tetap" {{ request('asset_type')=='aset_tetap'?'selected':'' }}>Aset Tetap</option>
                <option value="atk" {{ request('asset_type')=='atk'?'selected':'' }}>ATK</option>
            </select>
        </div>
        <div class="col-12">
            <button class="btn btn-primary">Tampilkan</button>
            <a href="{{ route('laporan.inventaris.pdf', request()->all()) }}" class="btn btn-danger">Export PDF</a>
            <a href="{{ route('laporan.inventaris.excel', request()->all()) }}" class="btn btn-success">Export Excel</a>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jenis</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Kondisi</th>
                <th>Lokasi</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->kondisi }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ $item->stok }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
