@extends('layouts.add')

@section('title', 'Data Aset')

@section('content')
<div class="container py-4">

    {{-- Tombol Export / Tambah --}}
    <div class="mb-3 d-flex gap-2">
        {{-- (Optional) Export --}}
        {{-- <a href="{{ route('assets.exportExcel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
        <a href="{{ route('assets.exportPdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a> --}}
        <a href="{{ route('assets.create') }}" class="btn btn-primary ms-auto">
            <i class="bi bi-plus-circle"></i> Tambah Aset
        </a>
    </div>

    <div class="card mb-4">
        {{-- Header Card --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">Data Aset</h2>
        </div>

        {{-- Search --}}
        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="input-group">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama aset atau lokasi...">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>

            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Table --}}
            @if ($assets->count() == 0)
                <div class="alert alert-secondary text-center">Belum ada data aset.</div>
            @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Kondisi</th>
                            <th>Umur (th)</th>
                            <th>Status Kelayakan</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assets as $i => $asset)
                            @php
                                $kelayakan = $asset->kelayakanAsset; // relasi ke tabel kelayakan_assets
                            @endphp
                            <tr class="align-middle">
                                <td>{{ $asset->nama }}</td>
                                <td>{{ $asset->kategori ?? '-' }}</td>
                                <td>{{ $asset->lokasi ?? '-' }}</td>
                                <td class="text-center">{{ $asset->kondisi }}</td>
                                <td class="text-center">{{ $asset->umur_tahun ?? 0 }}</td>
                                <td class="text-center">
                                    @if ($kelayakan)
                                        @if ($kelayakan->status_kelayakan === 'Layak')
                                            <span class="badge bg-success">{{ $kelayakan->status_kelayakan }}</span>
                                        @elseif ($kelayakan->status_kelayakan === 'Kurang Layak')
                                            <span class="badge bg-warning text-dark">{{ $kelayakan->status_kelayakan }}</span>
                                        @elseif ($kelayakan->status_kelayakan === 'Tidak Layak')
                                            <span class="badge bg-danger">{{ $kelayakan->status_kelayakan }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $kelayakan->status_kelayakan }}</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Belum Dinilai</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-warning mb-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus aset ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger mb-1">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        {{-- Footer Card --}}
        <div class="card-footer clearfix">
            
        </div>
    </div>
</div>
@endsection
