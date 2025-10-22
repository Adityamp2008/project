@extends('layouts.add')
@section('title', 'Kelola Akun')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Kelola Akun</h3>

    {{-- Tombol Tambah Akun --}}
    <div class="mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Akun
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Data Akun --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <strong>Daftar Akun Pengguna</strong>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered mb-0 align-middle">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $i => $user)
                        <tr>

                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ ucfirst($user->role) }}</td>

                            <td class="text-center">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus akun ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                Belum ada akun yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination (kalau ada) --}}
        @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
