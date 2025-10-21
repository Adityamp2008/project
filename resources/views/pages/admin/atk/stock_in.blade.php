@extends('layouts.add')
@section('title', 'Barang Masuk')

@section('content')
<div class="container py-4">
    <h3>Tambah Stok: {{ $atk->name }}</h3>

    <form action="{{ route('atk.stockin', $atk->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Jumlah Masuk</label>
            <input type="number" name="quantity" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label>Keterangan / Referensi</label>
            <input type="text" name="reference" class="form-control" placeholder="Contoh: Pembelian bulan Oktober">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('atk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
