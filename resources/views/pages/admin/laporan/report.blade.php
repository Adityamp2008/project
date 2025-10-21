@extends('layouts.add')
@section('title', 'Laporan Stok ATK')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Laporan Stok ATK</h3>

    <!-- Filter -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Dari Tanggal</label>
            <input type="date" name="from" value="{{ request('from', now()->subMonth()->format('Y-m-d')) }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Sampai Tanggal</label>
            <input type="date" name="to" value="{{ request('to', now()->format('Y-m-d')) }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Nama Barang</label>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari barang...">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <!-- Tombol Export -->
    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('laporan.report.pdf', request()->query()) }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>

    <!-- Tabel Laporan -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Pengguna</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                    <tr class="text-center">
                        <td>{{ $trx->created_at->format('d/m/Y ') }}</td>
                        <td>{{ $trx->item->name ?? '-' }}</td>
                        <td>
                            @if($trx->type === 'in')
                                <span class="badge bg-success">Masuk</span>
                            @else
                                <span class="badge bg-danger">Keluar</span>
                            @endif
                        </td>
                        <td>{{ $trx->quantity }}</td>
                        <td>{{ $trx->reference ?? '-' }}</td>
                        <td>{{ $trx->user->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
    {{ $transactions->links() }}
</div>

    </div>
</div>
@endsection
