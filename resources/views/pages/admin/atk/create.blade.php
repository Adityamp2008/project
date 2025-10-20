@extends('layouts.add')
@section('content')
    
    <div class="container py-4">
    <h2 class="mb-4">Tambah Item ATK</h2>

    <form action="{{ route('atk.store') }}" method="POST">
        @csrf
        <div class="mb-3">
    <label class="form-label">Kode Barang</label>
    <input type="text" name="code" class="form-control" value="{{ $newCode }}" readonly>
</div>


        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" placeholder="Nama barang">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

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

        <div class="mb-3">
            <label class="form-label">Batas Minimum Stok</label>
            <input type="number" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold', 5) }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('atk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection