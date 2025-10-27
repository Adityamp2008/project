@extends('layouts.guest')

@section('title', 'Persetujuan Penghapusan ATK')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Daftar Pengajuan Penghapusan ATK</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Item</th>
                        <th>Alasan</th>
                        <th>Diajukan Oleh</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penghapusan as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->item->name ?? 'Item Terhapus' }}</td>
                            <td>{{ $p->alasan }}</td>
                            <td>{{ $p->user->name }}</td>
                            <td>
                                @if($p->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($p->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->status == 'menunggu')
                                    <form method="POST" action="{{ route('penghapusan_atk.setujui', $p->id) }}" class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menyetujui penghapusan data ini?')">
                                        @csrf
                                        <button class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('penghapusan_atk.tolak', $p->id) }}" class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menolak penghapusan data ini?')">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                @else
                                    <em>-</em>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada pengajuan penghapusan data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
