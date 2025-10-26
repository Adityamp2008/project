@extends('layouts.app')

@section('title', 'Data Aset')

@section('content')
<div class="container py-4">

    {{-- Tombol Tambah --}}
    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('assets.create') }}" class="btn btn-primary ms-auto">
            <i class="bi bi-plus-circle"></i> Tambah Aset
        </a>
    </div>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">Data Aset</h2>
        </div>

        <div class="card-body">

            {{-- Search --}}
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

            {{-- Tabel --}}
            @if ($assets->isEmpty())
                <div class="alert alert-secondary text-center">Belum ada data aset.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Tanggal Perolehan</th>
                                <th>Kondisi</th>
                                <th>Umur (th)</th>
                                <th>Status Kelayakan</th>
                                <th width="160">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets as $asset)
                                @php
                                    // Hitung umur
                                    $umur = (int)($asset->umur_tahun ?? 0);
                            
                                    // Tentukan status kelayakan
                                    if ($asset->pernah_diperbaiki) {
                                        $status = 'Layak';
                                        $badge = 'success';
                                        $icon = 'bi-check-circle';
                                    } elseif ($umur < 2) {
                                        $status = 'Layak';
                                        $badge = 'success';
                                        $icon = 'bi-check-circle';
                                    } elseif ($umur < 5) {
                                        $status = 'Kurang Layak';
                                        $badge = 'warning';
                                        $icon = 'bi-exclamation-triangle';
                                    } else {
                                        $status = 'Tidak Layak';
                                        $badge = 'danger';
                                        $icon = 'bi-x-circle';
                                    }
                                @endphp
                            
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start">
                                        {{ $asset->nama }}
                                        @if($asset->pernah_diperbaiki)
                                            <i class="bi bi-star-fill text-warning ms-1" title="Sudah Pernah Diperbaiki"></i>
                                        @endif
                                    </td>
                                    <td>{{ $asset->kategori ?? '-' }}</td>
                                    <td>{{ $asset->lokasi ?? '-' }}</td>
                                    <td>
                                        {{ $asset->tanggal_perolehan 
                                            ? \Carbon\Carbon::parse($asset->tanggal_perolehan)->format('d-m-Y') 
                                            : '-' }}
                                    </td>
                                    <td>{{ ucfirst($asset->kondisi ?? '-') }}</td>
                                    <td>{{ $umur }}</td>
                                    <td>
                                        <span class="badge bg-{{ $badge }}">
                                            <i class="bi {{ $icon }}"></i> {{ $status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('assets.edit', $asset->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                            
                                        @php
                                            $laporanTerakhir = $asset->laporanKelayakanTerakhir;
                                            $isApproved = $laporanTerakhir && $laporanTerakhir->status === 'approved';
                                        @endphp
                                        
                                        <a href="{{ route('assets.formHapus', $asset->id) }}" 
                                           class="btn btn-sm btn-danger" title="Ajukan Penghapusan">
                                           <i class="bi bi-trash"></i>
                                        </a>

                            
                                        {{-- Tombol Perbaikan muncul hanya jika status tidak layak/kurang layak dan disetujui --}}
                                        @if(in_array($status, ['Kurang Layak', 'Tidak Layak']) && $isApproved)
                                            <a href="{{ route('assets.formPerbaikan', $asset->id) }}" 
                                               class="btn btn-sm btn-primary" title="Perbaiki">
                                                <i class="bi bi-tools"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
