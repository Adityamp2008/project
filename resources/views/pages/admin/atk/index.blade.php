@extends('layouts.add')

@section('title', 'Data ATK')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data ATK</h2>
        <a href="{{ route('atk.create') }}" class="btn btn-primary">+ Tambah Item</a>
    </div>

    {{-- Search --}}
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
        <div class="alert alert-info">Belum ada data ATK.</div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Barcode</th>
                    <th>Status</th>
                    <th width="130">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $i => $item)
                <tr>
                    <td class="text-center">{{ $items->firstItem() + $i }}</td>
                    <td class="text-center">{{ $item->code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category ?? '-' }}</td>
                    <td class="text-center">{{ $item->unit ?? '-' }}</td>
                    <td class="text-center">{{ $item->stock }}</td>

                    <td class="text-center">
                        @if($item->barcode)
                            {{-- tampilkan barcode (pakai milon/barcode) --}}
                            {!! DNS1D::getBarcodeHTML($item->barcode, 'C128', 1.5, 40) !!}
                            <div style="font-size:12px;">{{ $item->barcode }}</div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <td class="text-center">
                        @if($item->active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <a href="{{ route('atk.edit', $item->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('atk.destroy', $item->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $items->links() }}
    </div>
    @endif
</div>
@endsection
