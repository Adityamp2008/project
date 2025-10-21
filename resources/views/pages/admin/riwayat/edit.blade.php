@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Riwayat</h2>

    <form action="{{ route('riwayat.update', $riwayat->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Asset</label>
            <select name="assets_id" class="form-control" required>
                @foreach ($assets as $asset)
                    <option value="{{ $asset->id }}" {{ $riwayat->assets_id == $asset->id ? 'selected' : '' }}>
                        {{ $asset->nama_asset }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tipe</label>
            <select name="tipe" class="form-control" required>
                <option value="penggunaan" {{ $riwayat->tipe == 'penggunaan' ? 'selected' : '' }}>Penggunaan</option>
                <option value="perbaikan" {{ $riwayat->tipe == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required>{{ $riwayat->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $riwayat->tanggal }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('riwayat.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
