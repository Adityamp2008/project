@extends('layouts.app')
@section('title', 'Barang Masuk')

@section('content')
<div class="container py-4">

    <div class="card">
        {{-- Header Card --}}
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">Tambah Stok: {{ $atk->name }}</h2>
        </div>

        {{-- Body Card --}}
        <div class="card-body">
            <form action="{{ route('atk.stockin', $atk->id) }}" method="POST">
                @csrf

                {{-- Jumlah Masuk --}}
                <div class="mb-3">
                    <label class="form-label">Jumlah Masuk</label>
                    <input type="number" name="quantity" class="form-control" min="1" required>
                </div>

                {{-- Keterangan / Referensi --}}
                <div class="mb-3">
                    <label class="form-label">Keterangan / Referensi</label>
                    <input type="text" name="reference" class="form-control" placeholder="Contoh: Pembelian bulan Oktober">
                </div>

                {{-- Tombol aksi --}}
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('atk.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
