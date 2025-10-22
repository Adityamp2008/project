@extends('layouts.add')
@section('title', 'Tambah Aset')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Tambah Aset Baru</h2>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Card Form --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            {{-- Alert sukses (jika ada) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Form Tambah Aset --}}
            <form action="{{ route('assets.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Aset</label>
                    <input 
                        type="text" 
                        name="nama" 
                        value="{{ old('nama') }}" 
                        class="form-control @error('nama') is-invalid @enderror" 
                        placeholder="Contoh: Laptop Lenovo ThinkPad" 
                        required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input 
                        type="text" 
                        name="kategori" 
                        value="{{ old('kategori') }}" 
                        class="form-control @error('kategori') is-invalid @enderror" 
                        placeholder="Contoh: Elektronik">
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input 
                        type="text" 
                        name="lokasi" 
                        value="{{ old('lokasi') }}" 
                        class="form-control @error('lokasi') is-invalid @enderror" 
                        placeholder="Contoh: Ruang IT / Gudang">
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Perolehan</label>
                    <input 
                        type="date" 
                        name="tanggal_perolehan" 
                        value="{{ old('tanggal_perolehan') }}" 
                        class="form-control @error('tanggal_perolehan') is-invalid @enderror">
                    @error('tanggal_perolehan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kondisi</label>
                    <select 
                        name="kondisi" 
                        class="form-select @error('kondisi') is-invalid @enderror" 
                        required>
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Cukup" {{ old('kondisi') == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                        <option value="Rusak" {{ old('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                    </select>
                    @error('kondisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea 
                        name="description" 
                        rows="3" 
                        class="form-control @error('description') is-invalid @enderror" 
                        placeholder="Tuliskan detail tambahan atau catatan aset...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-repeat"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
