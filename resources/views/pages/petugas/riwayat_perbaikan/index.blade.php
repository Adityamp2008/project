@extends('layouts.app')

@section('title', 'Riwayat Perbaikan')
@section('content')
<div class="container py-4">
    <h3 class="mb-4">Riwayat Perbaikan Aset</h3>

    {{-- Alert session messages --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Search & Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('riwayat-perbaikan.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Nama Aset</label>
                    <input type="text" name="nama_asset" class="form-control"
                        value="{{ request('nama_asset') }}" placeholder="Cari nama aset...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Petugas</label>
                    <input type="text" name="diperbaiki_oleh" class="form-control"
                        value="{{ request('diperbaiki_oleh') }}" placeholder="Nama petugas...">
                </div>
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('riwayat-perbaikan.export-pdf', request()->query()) }}" target="_blank" class="btn btn-danger">
    <i class="bi bi-file-earmark-pdf"></i> Export PDF
</a>

                    <a href="{{ route('riwayat-perbaikan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-repeat"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>


    {{-- Tabel Data --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Aset</th>
                    <th>Kategori</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Deskripsi</th>
                    <th>Biaya</th>
                    <th>Diperbaiki Oleh</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($riwayat as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->asset->nama ?? '-' }}</td>
                    <td>{{ $r->asset->kategori->nama ?? '-' }}</td>
                    <td>{{ $r->tanggal_perbaikan ? \Carbon\Carbon::parse($r->tanggal_perbaikan)->format('d-m-Y') : '-' }}</td>
                    <td>@if ($r->tanggal_selesai)
                            {{ \Carbon\Carbon::parse($riwayat->tanggal_selesai)->format('d-m-Y') }}
                        @else
                            <span class="text-warning">Belum selesai</span>
                        @endif
                    </td>
                    <td>{{ $r->description ?? '-' }}</td>
                    <td>Rp {{ number_format($r->biaya, 0, ',', '.') }}</td>
                    <td>{{ $r->diperbaiki_oleh ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-muted">Belum ada data riwayat perbaikan aset.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
