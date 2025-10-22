@extends('layouts.add')
@section('title', 'Dashboard Super Admin')

@section('content')
<div class="container-fluid py-3">

  {{-- === HEADER === --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Dashboard Super Admin</h4>
    <small class="text-muted">Selamat datang, {{ Auth::user()->name }}</small>
  </div>

  {{-- === STATISTIK KOTAK UTAMA === --}}
  <div class="row g-3">
    {{-- Total Aset --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-primary">
        <div class="inner">
          <h3>{{ $total_aset ?? 0 }}</h3>
          <p>Total Aset</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
          <path d="M3 3h18v2H3V3zm2 4h14v2H5V7zm-2 4h18v2H3v-2zm2 4h14v2H5v-2zm-2 4h18v2H3v-2z"/>
        </svg>
        <a href="{{ route('assets.index') }}"
           class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
          More info <i class="bi bi-link-45deg"></i>
        </a>
      </div>
    </div>

    {{-- Aset Layak --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-success">
        <div class="inner">
          <h3>{{ $aset_layak ?? 0 }}</h3>
          <p>Aset Layak</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
          <path d="M9 16.17l-3.88-3.88L4 13.41 9 18.41l12-12-1.41-1.41z"/>
        </svg>
      </div>
    </div>

    {{-- Aset Tidak Layak --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-danger">
        <div class="inner">
          <h3>{{ $aset_tidak_layak ?? 0 }}</h3>
          <p>Aset Tidak Layak</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10
          10-4.48 10-10S17.52 2 12 2zm0 15h-.01M12 7v6"/>
        </svg>
      </div>
    </div>

    {{-- Stok Rendah --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-warning">
        <div class="inner">
          <h3>{{ $stok_rendah ?? 0 }}</h3>
          <p>Stok ATK Menipis</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 22c1.1 0 2-.9 2-2H10c0 1.1.9 2 2 2zm6-6v-5
          c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5S10.5 3.17
          10.5 4v.68C7.63 5.36 6 7.92 6 11v5l-1.7 1.7c-.1.1-.3.3-.3.6v.2c0
          .5.4.9.9.9h14.2c.5 0 .9-.4.9-.9v-.2c0-.3-.2-.5-.3-.6L18 16z"/>
        </svg>
        <a href="{{ route('atk.index') }}"
           class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
          More info <i class="bi bi-link-45deg"></i>
        </a>
      </div>
    </div>
  </div>

  {{-- === GRAFIK DAN NOTIFIKASI === --}}
  <div class="row g-3 mt-2">
    {{-- Grafik Kelayakan --}}
    <div class="col-lg-8">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0"><i class="bi bi-graph-up"></i> Statistik Kelayakan Aset</h6>
          <small class="text-muted">Per Tahun</small>
        </div>
        <div class="card-body">
          <div id="chartKelayakan" style="height: 300px;"></div>
        </div>
      </div>
    </div>

    {{-- Notifikasi Aset --}}
    <div class="col-lg-4">
      <div class="card shadow-sm">
        <div class="card-header">
          <h6 class="mb-0"><i class="bi bi-bell-fill"></i> Notifikasi Aset Bermasalah</h6>
        </div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush">
            @forelse ($notif_aset ?? [] as $n)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $n['nama'] }}</span>
                <span class="badge bg-danger">{{ $n['status'] }}</span>
              </li>
            @empty
              <li class="list-group-item text-center text-muted">Tidak ada notifikasi</li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>

  {{-- === Grafik Pemakaian ATK === --}}
  <div class="card mt-3 shadow-sm">
    <div class="card-header">
      <h6 class="mb-0"><i class="bi bi-pencil-square"></i> Pemakaian ATK per Bulan</h6>
    </div>
    <div class="card-body">
      <div id="chartAtk" style="height: 300px;"></div>
    </div>
  </div>

  {{-- === Riwayat Perbaikan Terbaru === --}}
  <div class="card shadow-sm mt-3">
    <div class="card-header">
      <h6 class="mb-0"><i class="bi bi-tools"></i> Riwayat Perbaikan Terbaru</h6>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped align-middle">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Nama Aset</th>
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Biaya</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($riwayat_perbaikan ?? [] as $i => $r)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $r->nama_aset ?? '-' }}</td>
            <td>{{ $r->tanggal ?? '-' }}</td>
            <td>{{ $r->deskripsi ?? '-' }}</td>
            <td>Rp {{ number_format($r->biaya ?? 0, 0, ',', '.') }}</td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted">Belum ada data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

{{-- === SCRIPT CHART === --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  // === Donut Kelayakan ===
  const chartKelayakan = new ApexCharts(document.querySelector("#chartKelayakan"), {
    chart: { type: 'donut', height: 300 },
    labels: ['Layak', 'Kurang Layak', 'Tidak Layak'],
    series: [{{ $aset_layak ?? 0 }}, {{ $aset_kurang_layak ?? 0 }}, {{ $aset_tidak_layak ?? 0 }}],
    colors: ['#198754', '#ffc107', '#dc3545'],
    legend: { position: 'bottom' }
  });
  chartKelayakan.render();

  // === Area Chart Pemakaian ATK ===
  const bulan = {!! json_encode(array_keys($grafik_atk->toArray() ?? [])) !!};
  const total = {!! json_encode(array_values($grafik_atk->toArray() ?? [])) !!};

  const chartAtk = new ApexCharts(document.querySelector("#chartAtk"), {
    chart: { type: 'area', height: 300 },
    series: [{ name: 'Pemakaian ATK', data: total }],
    xaxis: { categories: bulan.map(b => 'Bulan ' + b) },
    stroke: { curve: 'smooth' },
    colors: ['#0d6efd']
  });
  chartAtk.render();
});
</script>
@endpush
@endsection
