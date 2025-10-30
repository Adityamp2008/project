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
                                <th width="250">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets as $asset)
                                @php
                                    $kelayakan = $asset->KelayakanAssets;
                                    $status = $kelayakan->status_kelayakan ?? 'Belum Dinilai';
                                    $badge = 'secondary';
                                    $icon = 'bi-question-circle';

                                    if ($status === 'Layak') {
                                        $badge = 'success';
                                        $icon = 'bi-check-circle';
                                    } elseif ($status === 'Kurang Layak') {
                                        $badge = 'warning';
                                        $icon = 'bi-exclamation-triangle';
                                    } elseif ($status === 'Tidak Layak') {
                                        $badge = 'danger';
                                        $icon = 'bi-x-circle';
                                    }

                                    $izin = $asset->izinPerbaikanTerakhir;
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <span>{{ $asset->nama }}</span>
                                            @if ($asset->pernah_diperbaiki)
                                                <i class="bi bi-wrench text-primary" title="Sudah Diperbaiki" style="font-size: 1rem;"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $asset->kategori->nama ?? '-' }}</td>
                                    <td>{{ $asset->lokasi ?? '-' }}</td>
                                    <td>{{ $asset->tanggal_perolehan ? \Carbon\Carbon::parse($asset->tanggal_perolehan)->format('d-m-Y') : '-' }}</td>
                                    <td>{{ ucfirst($asset->kondisi ?? '-') }}</td>
                                    <td>{{ $asset->umur_tahun ?? 0 }}</td>
                                    <td>{{ $asset->description ?? '-' }}</td>

                                    {{-- Status Kelayakan --}}
                                    <td>
                                        <span class="badge bg-{{ $badge }}">
                                            <i class="bi {{ $icon }}"></i> {{ $status }}
                                        </span>
                                    </td>

                                    {{-- Tombol Aksi --}}
                                    <td class="d-flex justify-content-center gap-1">
                                        {{-- Edit --}}
                                        <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-warning" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Ajukan Hapus --}}
                                        <a href="{{ route('assets.formHapus', $asset->id) }}" class="btn btn-sm btn-danger" title="Ajukan Penghapusan">
                                            <i class="bi bi-trash"></i>
                                        </a>

                                        {{-- Tombol Perbaikan --}}
                                        @php
                                            $kondisi_baik = strtolower($asset->kondisi) === 'baik';
                                            $layak = strtolower($status) === 'layak';
                                        @endphp

                                        @if (!($kondisi_baik && $layak))
                                            {{-- Hanya tampilkan tombol jika aset tidak baik atau tidak layak --}}
                                            @if ($izin)
                                                {{-- Ada izin, cek status --}}
                                                @switch($izin->status)
                                                    @case('pending')
                                                        {{-- Menunggu persetujuan --}}
                                                        <button class="btn btn-sm btn-secondary" disabled title="Menunggu persetujuan">
                                                            <i class="bi bi-hourglass-split"></i>
                                                        </button>
                                                        @break

                                                    @case('approved')
                                                        {{-- Bisa diperbaiki --}}
                                                        <a href="{{ route('assets.formPerbaikan', $asset->id) }}" class="btn btn-sm btn-primary" title="Perbaikan Aset">
                                                            <i class="bi bi-tools"></i>
                                                        </a>
                                                        @break

                                                    @case('in_progress')
                                                        {{-- Sedang diperbaiki --}}
                                                        <a href="{{ route('assets.selesaikanPerbaikan', $izin->id) }}" class="btn btn-sm btn-success" title="Selesaikan Perbaikan">
                                                            <i class="bi bi-check-circle"></i>
                                                        </a>
                                                        @break

                                                    @case('completed')
                                                        {{-- Perbaikan selesai, bisa kirim ke Kepdin --}}
                                                        <a href="{{ route('assets.kirimKeKepdin', $izin->id) }}" class="btn btn-sm btn-info" title="Kirim ke Kepdin">
                                                            <i class="bi bi-send"></i>
                                                        </a>
                                                        @break

                                                    @case('final_approved')
                                                        {{-- Sudah disetujui --}}
                                                        <span class="badge bg-success">Sudah Disetujui</span>
                                                        @break
                                                @endswitch
                                            @else
                                                {{-- Tidak ada izin, tombol tidak muncul --}}
                                            @endif
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
