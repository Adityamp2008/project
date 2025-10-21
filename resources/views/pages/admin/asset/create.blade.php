@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Aset Baru</h3>

    <form action="{{ route('assets.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Aset</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Kondisi</label>
            <select name="kondisi_id" class="form-select" required>
                <option value="">-- Pilih Kondisi --</option>
                @foreach($kondisis as $kondisi)
                    <option value="{{ $kondisi->id }}">{{ $kondisi->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <select name="lokasi_id" class="form-select" required>
                <option value="">-- Pilih Lokasi --</option>
                @foreach($lokasis as $lokasi)
                    <option value="{{ $lokasi->id }}">{{ $lokasi->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Perolehan</label>
            <input type="date" name="tanggal_perolehan" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
