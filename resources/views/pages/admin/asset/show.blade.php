@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Detail Aset</h1>

    <div class="border p-4 rounded shadow">
        <p><strong>Nama:</strong> {{ $assets->nama }}</p>
        <p><strong>Kategori:</strong> {{ $assets->kategori->nama }}</p>
        <p><strong>Kondisi:</strong> {{ $assets->kondisi->nama }}</p>
        <p><strong>Lokasi:</strong> {{ $assets->lokasi->nama }}</p>
        <p><strong>Tanggal Perolehan:</strong> {{ \Carbon\Carbon::parse($assets->tanggal_perolehan)->format('d M Y') }}</p>

        <hr class="my-4">

        <h2 class="text-xl font-semibold mb-2">Riwayat Penggunaan & Perbaikan</h2>
        <ul class="list-disc ml-5">
            @forelse($assets->riwayat as $riwayat)
                <li>{{ $riwayat->keterangan }} ({{ \Carbon\Carbon::parse($riwayat->created_at)->format('d M Y') }})</li>
            @empty
                <li>Belum ada riwayat.</li>
            @endforelse
        </ul>
    </div>

    <a href="{{ route('assets.index') }}" class="mt-4 inline-block text-blue-500">← Kembali</a>
</div>
@endsection
