@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Data Aset</h3>

    <form action="{{ route('assets.update', $assets->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Aset</label>
            <input type="text" name="nama" class="form-control" value="{{ $assets->nama }}" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori_id" class="form-select" required>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ $assets->kategori_id == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Kondisi</label>
            <select name="kondisi_id" class="form-select" required>
                @foreach($kondisis as $kondisi)
                    <option value="{{ $kondisi->id }}" {{ $assets->kondisi_id == $kondisi->id ? 'selected' : '' }}>
                        {{ $kondisi->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <select name="lokasi_id" class="form-select" required>
                @foreach($lokasis as $lokasi)
                    <option value="{{ $lokasi->id }}" {{ $assets->lokasi_id == $lokasi->id ? 'selected' : '' }}>
                        {{ $lokasi->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Perolehan</label>
            <input type="date" name="tanggal_perolehan" class="form-control" value="{{ $assets->tanggal_perolehan }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
