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
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nama aset atau lokasi...">
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
                                <th>Deskripsi</th>
                                <th>Status Kelayakan</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets as $asset)
                                @php
                                    $umur = (int)($asset->umur_tahun ?? 0);

                                    $laporanTerakhir = $asset->laporanKelayakanTerakhir;
                                    $isApproved = $laporanTerakhir && $laporanTerakhir->status === 'approved';
                                    $isPending = $laporanTerakhir && $laporanTerakhir->status === 'pending';
                                    $bisaPerbaiki = !$asset->pernah_diperbaiki && $isPending;

                                    // Status kelayakan
                                    if ($asset->pernah_diperbaiki || $isApproved) {
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

                                    {{-- Kolom Nama dengan ikon "Sudah Diperbaiki" --}}
                                    <td class="text-start">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <span>{{ $asset->nama }}</span>
                                            @if ($asset->pernah_diperbaiki || $isApproved)
                                                    <i class="bi bi-wrench text-primary" title="Sudah Diperbaiki" style="font-size: 1rem;"></i>
                                            @endif
                                        </div>
                                    </td>
                                    


                                    <td>{{ $asset->kategori ?? '-' }}</td>
                                    <td>{{ $asset->lokasi ?? '-' }}</td>
                                    <td>{{ $asset->tanggal_perolehan ? \Carbon\Carbon::parse($asset->tanggal_perolehan)->format('d-m-Y') : '-' }}</td>
                                    <td>{{ ucfirst($asset->kondisi ?? '-') }}</td>
                                    <td>{{ $umur }}</td>
                                    <td>{{ $asset->description ?? '-' }}</td>

                                    {{-- Kolom Status Kelayakan --}}
                                    <td>
                                        <span class="badge bg-{{ $badge }}">
                                            <i class="bi {{ $icon }}"></i> {{ $status }}
                                        </span>
                                        @if($isPending)
                                            <span class="badge bg-secondary ms-1" title="Izin Perbaikan Pending">
                                                <i class="bi bi-hourglass-split"></i> Pending
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td>
                                        <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-warning" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    
                                        <a href="{{ route('assets.formHapus', $asset->id) }}" class="btn btn-sm btn-danger" title="Ajukan Penghapusan">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    
                                        {{-- Tombol logika izin & perbaikan --}}
                                        @php
                                            $izin = $asset->izinPerbaikanTerakhir;
                                        @endphp
                                    
                                        @if ($izin && $izin->status === 'approved')
                                            <a href="{{ route('assets.formPerbaikan', $asset->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-tools"></i> 
                                            </a>
                                        @elseif ($izin && $izin->status === 'pending')
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="bi bi-hourglass-split"></i> 
                                            </button>
                                        @else
                                            <a href="{{ route('assets.ajukanIzinPerbaikan', $asset->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-envelope"></i> Ajukan Izin
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
