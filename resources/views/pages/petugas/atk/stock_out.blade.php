@extends('layouts.app')
@section('title', 'Barang Keluar')

@section('content')

@php
use Illuminate\Support\Facades\Auth;
@endphp
<div class="container py-4">

    <div class="card">
        {{-- Header Card --}}
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-title mb-0">Kurangi Stok: {{ $atk->name }}</h2>
        </div>

        {{-- Body Card --}}
        <div class="card-body">
            <form action="{{ route('atk.stockout', $atk->id) }}" method="POST">
                @csrf

                {{-- Jumlah Keluar --}}
                <div class="mb-3">
                    <label class="form-label">Jumlah Keluar</label>
                    <input type="number" name="quantity" class="form-control" min="1" required>
                </div>

                               {{-- Dipakai Oleh --}}
<div class="mb-3">
    <label class="form-label">Dipakai oleh</label>
    <input 
        type="text" 
        name="used_by" 
        class="form-control" 
        value="{{ Auth::user()->name }}" 
        readonly
    >
</div>
                {{-- Keterangan --}}
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="reference" class="form-control" placeholder="Contoh: Untuk keperluan kantor">
                </div>

                {{-- Tombol aksi --}}
                <div class="d-flex gap-2">
                    <button class="btn btn-danger">Kurangi Stok</button>
                    <a href="{{ route('atk.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
