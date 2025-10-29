@extends('layouts.app')

@section('title', 'Tambah Item ATK')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        {{-- Header Card --}}
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Item ATK</h5>
        </div>

        {{-- Body Card --}}
        <div class="card-body">
            <form action="{{ route('atk.store') }}" method="POST">
                @csrf

                {{-- Baris 1: Kode + Nama Barang --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kode Barang</label>
                        <input type="text" name="code" class="form-control" value="{{ $newCode }}" readonly style="background-color: #f8f9fa;">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="name" 
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="Contoh: Pulpen Gel Hitam">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Baris 2: Satuan / Stok / Kategori --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Satuan</label>
                        <input type="text" name="unit" class="form-control" value="{{ old('unit') }}" placeholder="pcs / box / rim">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stok Awal</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}">
                    </div>
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori ATK</label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoriAtk as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>


                {{-- Baris 3: Batas Minimum Stok --}}
                <div class="mb-3">
                    <label class="form-label">Batas Minimum Stok</label>
                    <input type="number" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold', 5) }}">
                </div>

                {{-- Baris 4: Deskripsi (Ditaruh paling bawah agar tidak boros ruang) --}}
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Tulis deskripsi singkat barang...">{{ old('description') }}</textarea>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('atk.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
