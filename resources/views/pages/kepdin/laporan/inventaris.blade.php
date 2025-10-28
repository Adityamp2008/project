@extends('layouts.guest')
@section('title','Laporan Inventaris')

@section('content')
<div class="container">
    <h3 class="mb-4">Laporan Inventaris</h3>

    <form method="GET" class="row g-3 mb-4 align-items-end">
      <div class="col-md-3">
        <label class="form-label">Jenis</label>
        <select name="asset_type" class="form-select">
          <option value="">Semua</option>
          <option value="aset_tetap" {{ request('asset_type')=='aset_tetap'?'selected':'' }}>Aset Tetap</option>
          <option value="atk" {{ request('asset_type')=='atk'?'selected':'' }}>ATK</option>
        </select>
      </div>
    
      {{-- Tombol di kanan --}}
      <div class="col-md-9 d-flex justify-content-end gap-2">
        <button class="btn btn-primary">
          <i class="fas fa-eye"></i> Tampilkan
        </button>
        <a href="{{ route('laporan.inventaris.pdf', request()->all()) }}" class="btn btn-danger">
          <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <a href="{{ route('laporan.inventaris.excel', request()->all()) }}" class="btn btn-success">
          <i class="fas fa-file-excel"></i> Export Excel
        </a>
      </div>
    </form>


    {{-- ===================== ASET TETAP ===================== --}}
    @if($assetType == '' || $assetType == 'aset_tetap')
        <h5 class="mt-4 mb-2">Aset Tetap</h5>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Kondisi</th>
                    <th>Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $asetItems = $items->where('jenis', 'Aset Tetap');
                @endphp
                @forelse($asetItems as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->kondisi }}</td>
                        <td>{{ $item->lokasi }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Tidak ada data aset tetap</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    {{-- ===================== ATK ===================== --}}
    @if($assetType == '' || $assetType == 'atk')
        <h5 class="mt-4 mb-2">Alat Tulis Kantor (ATK)</h5>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $atkItems = $items->where('jenis', 'ATK');
                @endphp
                @forelse($atkItems as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->stok }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center">Tidak ada data ATK</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif
</div>
@endsection
