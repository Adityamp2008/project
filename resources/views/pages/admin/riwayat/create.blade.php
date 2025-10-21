@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Riwayat</h2>

    <form action="{{ route('riwayat.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Asset</label>
            <select name="assets_id" class="form-control" required>
                <option value="">-- Pilih Asset --</option>
                @foreach ($assets as $asset)
                    <option value="{{ $asset->id }}">{{ $asset->nama_asset }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tipe</label>
            <select name="tipe" class="form-control" required>
                <option value="penggunaan">Penggunaan</option>
                <option value="perbaikan">Perbaikan</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('riwayat.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
