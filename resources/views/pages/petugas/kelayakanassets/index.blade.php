@extends('layouts.app')

@section('title', 'Kelayakan Aset')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Daftar Kelayakan Aset</h3>

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
                    <th>Kondisi</th>
                    <th>Status Laporan</th>
                    <th>Catatan Kepdin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelayakanassets as $i => $data)
                    @php
                        $laporan = \App\Models\LaporanKelayakan::where('asset_id', $data->asset_id)->latest()->first();
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $data->asset->nama ?? '-' }}</td>
                        <td>{{ ucfirst($data->asset->kondisi ?? '-') }}</td>
                        <td>
                            @if($laporan)
                                <span class="badge bg-{{ 
                                    $laporan->status == 'approved' ? 'success' : 
                                    ($laporan->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($laporan->status) }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Belum Dilaporkan</span>
                            @endif
                        </td>
                        <td>{{ $laporan->catatan_kepdin ?? '-' }}</td>
                        <td>
                            @if(!$laporan || $laporan->status != 'pending')
                                <form action="{{ route('kelayakanassets.laporkan', $data->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm"
                                        onclick="return confirm('Kirim laporan ke Kepdin?')">
                                        <i class="bi bi-send"></i> Laporkan
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="bi bi-hourglass-split"></i> Menunggu
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">Belum ada data aset yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
