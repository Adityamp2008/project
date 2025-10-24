@extends('layouts.add')

@section('title', 'Data ATK')

@section('content')
<div class="container py-4">

    {{-- Tombol Export --}}
    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('atk.exportExcel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
        <a href="{{ route('atk.exportPdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>

    <div class="card mb-4">
        {{-- Header Card --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">Data ATK</h2>
            <a href="{{ route('atk.create') }}" class="btn btn-primary ms-auto">Tambah Item</a>
        </div>

        {{-- Search --}}
        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nama barang...">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($items->count() == 0)
                <div class="alert alert-secondary text-center">Belum ada data ATK.</div>
            @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $i => $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $items->firstItem() + $i }}</td>
                            <td class="text-center">{{ $item->code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category ?? '-' }}</td>
                            <td class="text-center">{{ $item->unit ?? '-' }}</td>
                            <td class="text-center">{{ $item->stock }}</td>
                            <td class="text-center">
    @if($item->stock == 0)
        <span class="badge bg-danger">Stok Kosong</span>
    @elseif($item->stock < 5)
        <span class="badge bg-warning">Stok Menipis</span>
    @else
        <span class="badge bg-success">Aman</span>
    @endif
</td>
                            <td class="text-center">
                                <a href="{{ route('atk.edit', $item->id) }}" class="btn btn-sm btn-warning mb-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('atk.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger mb-1">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('atk.stockin.form', $item->id) }}" class="btn btn-sm btn-success mb-1">
                                    <i class="bi bi-plus-circle"></i>
                                </a>
                                <a href="{{ route('atk.stockout.form', $item->id) }}" class="btn btn-sm btn-dark mb-1">
                                    <i class="bi bi-dash-circle"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer Card --}}
        <div class="card-footer clearfix">
            {{ $items->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
