@extends('layouts.app')

@section('title', 'Perbaikan Aset')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Form Perbaikan Aset: {{ $asset->nama }}</h3>

    <form action="{{ route('assets.simpanPerbaikan', $asset->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Aset</label>
            <input type="text" class="form-control" value="{{ $asset->nama }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi Perbaikan</label>
            <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi_perbaikan') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Perbaikan</label>
            <input type="date" name="tanggal_perbaikan" class="form-control" value="{{ old('tanggal_perbaikan', date('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Biaya (Rp)</label>
            <input type="number" name="biaya" class="form-control" value="{{ old('biaya') }}" placeholder="Masukkan biaya perbaikan">
        </div>

        <div class="mb-3">
            <label class="form-label">Diperbaiki Oleh</label>
            <input type="text" name="diperbaiki_oleh" class="form-control"
                   value="{{ old('diperbaiki_oleh', auth()->user()->name ?? '') }}"
                   placeholder="Nama yang memperbaiki (otomatis terisi)" />
        </div>

        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('assets.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Perbaikan
            </button>
        </div>
    </form>
</div>
@endsection
