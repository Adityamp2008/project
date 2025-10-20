@extends('layouts.add')

@section('title', 'Edit ATK')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Item ATK</h2>

    <form action="{{ route('atk.update', $atk->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Kode</label>
            <input type="text" class="form-control" value="{{ $atk->code }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $atk->name) }}">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $atk->description) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Satuan</label>
                <input type="text" name="unit" class="form-control" value="{{ old('unit', $atk->unit) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="category" class="form-control" value="{{ old('category', $atk->category) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Batas Minimum Stok</label>
                <input type="number" name="low_stock_threshold" class="form-control"
                       value="{{ old('low_stock_threshold', $atk->low_stock_threshold) }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Status Aktif</label>
            <select name="active" class="form-select">
                <option value="1" {{ old('active', $atk->active) ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ !old('active', $atk->active) ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('atk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
