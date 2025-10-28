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

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Aset</th>
                    <th>Tanggal Perbaikan</th>
                    <th>Deskripsi</th>
                    <th>Biaya</th>
                    <th>Diperbaiki Oleh</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayats as $i => $r)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $r->asset->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->tanggal_perbaikan)->format('d-m-Y') }}</td>
                        <td class="text-start">{{ $r->deskripsi ?? '-' }}</td>
                        <td>Rp {{ number_format($r->biaya, 0, ',', '.') }}</td>
                        <td>{{ $r->diperbaiki_oleh ?? '-' }}</td>
                        <td>
                            {{-- Badge status perbaikan --}}
                            @if ($r->status == 'selesai')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </span>
                            @elseif ($r->status == 'proses')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-hourglass-split"></i> Proses
                                </span>
                            @elseif ($r->status == 'gagal')
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle"></i> Gagal
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="bi bi-clock"></i> Belum Dimulai
                                </span>
                            @endif
                        </td>
                        <td>
                            {{-- Tombol aksi, bisa disesuaikan --}}
                            @if ($r->status == 'proses')
                                <form action="{{ route('riwayat.selesai', $r->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm"
                                        onclick="return confirm('Tandai perbaikan ini sebagai selesai?')">
                                        <i class="bi bi-check-circle"></i> Tandai Selesai
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="bi bi-info-circle"></i> Tidak Ada Aksi
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-muted">Belum ada data riwayat perbaikan aset.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
