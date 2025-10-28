@extends('layouts.guest')

@section('title', 'Dashboard Kepdin')

@section('content')
<div class="container-fluid py-3">

  {{-- HEADER --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Dashboard Kepala Dinas</h4>
    <small class="text-muted">Selamat datang, {{ Auth::user()->name }}</small>
  </div>

  {{-- STATISTIK UTAMA --}}
  <div class="row g-3">

    {{-- Total Aset --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-primary">
        <div class="inner">
          <h3>{{ $data['totalAset'] ?? 0 }}</h3>
          <p>Total Aset Tetap</p>
        </div>
        <i class="bi bi-box-seam small-box-icon"></i>
      </div>
    </div>

    {{-- Total ATK --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-success">
        <div class="inner">
          <h3>{{ $data['totalAtk'] ?? 0 }}</h3>
          <p>Total ATK</p>
        </div>
        <i class="bi bi-pencil-square small-box-icon"></i>
      </div>
    </div>

    {{-- Laporan Kelayakan --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-info">
        <div class="inner">
          <h3>{{ $data['totalLaporanKelayakan'] ?? 0 }}</h3>
          <p>Laporan Kelayakan</p>
        </div>
        <i class="bi bi-clipboard-check small-box-icon"></i>
      </div>
    </div>

    {{-- Riwayat Perbaikan --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-warning">
        <div class="inner">
          <h3>{{ $data['totalPerbaikan'] ?? 0 }}</h3>
          <p>Riwayat Perbaikan</p>
        </div>
        <i class="bi bi-tools small-box-icon"></i>
      </div>
    </div>
  </div>

  {{-- NOTIFIKASI --}}
  <div class="row g-3 mt-3">
    <div class="col-lg-12">
      <div class="card shadow-sm">
        <div class="card-header">
          <h6 class="mb-0"><i class="bi bi-bell-fill"></i> Notifikasi Aset Bermasalah</h6>
        </div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush">
            @forelse($notifikasi as $notif)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $notif['nama'] }}</span>
                <span class="badge bg-danger">{{ $notif['status'] }}</span>
              </li>
            @empty
              <li class="list-group-item text-center text-muted">Tidak ada notifikasi</li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>



</div>
@endsection
