@extends('layouts.app')

@section('title', 'Ajukan Penghapusan Aset')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Ajukan Penghapusan Aset</h3>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <p><strong>Nama Aset:</strong> {{ $asset->nama }}</p>
            <p><strong>Kategori:</strong> {{ $asset->kategori }}</p>
            <p><strong>Lokasi:</strong> {{ $asset->lokasi }}</p>

            <form method="POST" action="{{ route('assets.ajukanHapus', $asset->id) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Alasan Penghapusan</label>
                    <textarea name="alasan" class="form-control" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-send"></i> Kirim Pengajuan
                </button>
                <a href="{{ route('assets.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
