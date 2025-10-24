@extends('layouts.app')

@section('title', 'Edit ATK')

@section('content')
<div class="container py-4">

    <div class="card">
        {{-- Header Card --}}
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">Edit Item ATK</h2>
        </div>

        {{-- Body Card --}}
        <div class="card-body">
            <form action="{{ route('atk.update', $atk->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Kode Barang --}}
                <div class="mb-3">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" class="form-control" value="{{ $atk->code }}" readonly style="background-color: #e9ecef;">
                </div>

                {{-- Nama Barang --}}
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="name" 
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $atk->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $atk->description) }}</textarea>
                </div>

                {{-- Baris input Satuan / Kategori / Batas Minimum --}}
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

                {{-- Status Aktif --}}
                <div class="mb-3">
                    <label class="form-label">Status Aktif</label>
                    <select name="active" class="form-select">
                        <option value="1" {{ old('active', $atk->active) ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !old('active', $atk->active) ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                {{-- Tombol aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('atk.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
