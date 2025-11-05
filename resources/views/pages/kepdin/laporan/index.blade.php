@extends('layouts.guest')

@section('title', 'Laporan Kelayakan Aset')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Laporan Kelayakan Aset</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('kepdin.laporan.index') }}" class="mb-3 d-flex gap-2">
    <input type="text" name="search" class="form-control" placeholder="Cari nama aset..." value="{{ request('search') }}">
    <select name="status" class="form-select">
        <option value="">Semua Status</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
    </select>
    <button class="btn btn-primary">Filter</button>
</form>


    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Aset</th>
                    <th>Kondisi</th>
                    <th>Status Laporan</th>
                    <th>Catatan Petugas</th>
                    <th>Catatan Kepdin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $i => $data)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $data->asset->nama ?? '-' }}</td>
                        <td>{{ ucfirst($data->asset->kondisi ?? '-') }}</td>
                        <td>
                            <span class="badge bg-{{ 
                                $data->status == 'approved' ? 'success' : 
                                ($data->status == 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($data->status) }}
                            </span>
                        </td>
                        <td>{{ $data->catatan_petugas ?? '-' }}</td>
                        <td>{{ $data->catatan_kepdin ?? '-' }}</td>
                        <td>
                            @if($data->status === 'pending')
                                <form action="{{ route('kepdin.laporan.approve', $data->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm" onclick="return confirm('Setujui laporan ini?')">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </form>
                                <form action="{{ route('kepdin.laporan.reject', $data->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Tolak laporan ini?')">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-muted">Belum ada laporan kelayakan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
