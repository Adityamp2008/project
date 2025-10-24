@extends('layouts.app')

@section('title', 'Tambah Item ATK')

@section('content')
<div class="container py-4">

    <div class="card">
        {{-- Header Card --}}


        {{-- Body Card --}}
        <div class="card-body">
            <form action="{{ route('atk.store') }}" method="POST">
                @csrf

                {{-- Kode Barang --}}
                <div class="mb-3">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="code" class="form-control" value="{{ $newCode }}" readonly style="background-color: #e9ecef;">
                </div>

                {{-- Nama Barang --}}
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="name" 
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="Nama barang">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                {{-- Baris input Satuan / Stok / Kategori --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Satuan</label>
                        <input type="text" name="unit" class="form-control" value="{{ old('unit') }}" placeholder="pcs / box / rim">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stok Awal</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="Tulis kategori">
                    </div>
                </div>

                {{-- Batas Minimum Stok --}}
                <div class="mb-3">
                    <label class="form-label">Batas Minimum Stok</label>
                    <input type="number" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold', 5) }}">
                </div>

                {{-- Tombol aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('atk.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
