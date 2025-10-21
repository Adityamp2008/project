@extends('layouts.add')
@section('title', 'Barang Keluar')

@section('content')
<div class="container py-4">
    <h3>Kurangi Stok: {{ $atk->name }}</h3>

    <form action="{{ route('atk.stockout', $atk->id) }}" method="POST">
        @csrf
        <div class="mb-3">
    <label>Dipakai oleh (opsional)</label>
    <select name="user_id" class="form-control">
        <option value="">-- Pilih Pegawai --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
</div>

        <div class="mb-3">
            <label>Dipakai oleh (opsional)</label>
            <input type="text" name="used_by" class="form-control" placeholder="Nama pegawai">
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="note" class="form-control" placeholder="Contoh: Untuk keperluan kantor">
        </div>

        <button class="btn btn-danger">Kurangi Stok</button>
        <a href="{{ route('atk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
