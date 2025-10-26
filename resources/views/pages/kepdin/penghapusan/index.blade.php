@extends('layouts.guest')

@section('title', 'Pengajuan Penghapusan Aset')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Daftar Pengajuan Penghapusan Aset</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Aset</th>
                        <th>Alasan</th>
                        <th>Diajukan Oleh</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuan as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->asset->nama }}</td>
                            <td>{{ $p->alasan }}</td>
                            <td>{{ $p->diajukan_oleh }}</td>
                            <td>
                                @if ($p->status === 'pending')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif ($p->status === 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if ($p->status === 'pending')
                                <form method="POST"
                                      action="{{ route('kepdin.penghapusan.setujui', $p->id) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI penghapusan data ini?')">
                                    @csrf
                                    <button class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle"></i> Setujui
                                    </button>
                                </form>
                                    <form method="POST" action="{{ route('kepdin.penghapusan.tolak', $p->id) }}" class="d-inline">
                                        @csrf
                                        <button class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i> Tolak</button>
                                    </form>
                                @else
                                    <i>-</i>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Belum ada pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
