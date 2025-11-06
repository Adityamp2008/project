@extends('layouts.app')

@section('title', 'Perbaikan Aset')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Form Perbaikan Aset: {{ $asset->nama }}</h3>

    <form action="{{ route('assets.simpanPerbaikan', $asset->id) }}" method="POST">
        @csrf

        {{-- Nama Aset --}}
        <div class="mb-3">
            <label class="form-label">Nama Aset</label>
            <input type="text" class="form-control" value="{{ $asset->nama }}" readonly>
        </div>

        {{-- Deskripsi Perbaikan --}}
        <div class="mb-3">
            <label class="form-label">Deskripsi Perbaikan</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>

        {{-- Tanggal Mulai Perbaikan --}}
        <div class="mb-3">
            <label class="form-label">Tanggal Mulai Perbaikan</label>
            <input type="date" name="tanggal_perbaikan" class="form-control"
                   value="{{ old('tanggal_perbaikan', date('Y-m-d')) }}" required>
        </div>

        {{-- Tanggal Selesai Perbaikan (opsional) --}}
        <div class="mb-3">
            <label class="form-label">Tanggal Selesai Perbaikan</label>
            <input type="date" name="tanggal_selesai" class="form-control"
                   value="{{ old('tanggal_selesai') }}"
                   placeholder="Isi jika perbaikan sudah selesai">
        </div>

        {{-- Biaya --}}
        <div class="mb-3">
            <label class="form-label">Biaya (Rp)</label>
            <input type="number" name="biaya" class="form-control"
                   value="{{ old('biaya') }}" placeholder="Masukkan biaya perbaikan" min="0">
        </div>

        {{-- Diperbaiki Oleh --}}
        <div class="mb-3">
            <label class="form-label">Diperbaiki Oleh</label>
            <input type="text" name="diperbaiki_oleh" class="form-control"
                   value="{{ old('diperbaiki_oleh', auth()->user()->name ?? '') }}"
                   placeholder="Nama petugas yang memperbaiki">
        </div>

        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('assets.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-tools"></i> Simpan Perbaikan
            </button>
        </div>
    </form>
</div>
@endsection
