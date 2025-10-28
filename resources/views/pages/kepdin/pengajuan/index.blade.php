@extends('layouts.guest')
@section('title', 'Daftar Pengajuan Stok ATK')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Daftar Pengajuan Stok ATK</h3>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    <!-- Tabel Pengajuan -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Diajukan Oleh</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->created_at->format('d/m/Y') }}</td>
                        <td>{{ $p->item->name ?? '-' }}</td>
                        <td>
                            @if($p->jenis === 'in')
                                <span class="badge bg-success">Penambahan</span>
                            @else
                                <span class="badge bg-danger">Pengurangan</span>
                            @endif
                        </td>
                        <td>{{ $p->jumlah }}</td>
                        <td>{{ $p->keterangan ?? '-' }}</td>
                        <td>{{ $p->user->name ?? '-' }}</td>
                        <td>
                            @if($p->status === 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($p->status === 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($p->status === 'menunggu')
                                <form action="{{ route('kepdin.pengajuan.setujui', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" 
                                        onclick="return confirm('Setujui pengajuan ini?')">
                                        <i class="bi bi-check-circle"></i> Setujui
                                    </button>
                                </form>

                                <form action="{{ route('kepdin.pengajuan.tolak', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Tolak pengajuan ini?')">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-muted">Tidak ada pengajuan stok.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
