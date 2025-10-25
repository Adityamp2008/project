@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="container-fluid py-3">

  {{-- HEADER --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Dashboard Petugas</h4>
    <small class="text-muted">Selamat datang, {{ Auth::user()->name }}</small>
  </div>

  {{-- STATISTIK KOTAK UTAMA --}}
  <div class="row g-3">
    {{-- Total Aset --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-primary">
        <div class="inner">
          <h3>{{ $total_aset ?? 0 }}</h3>
          <p>Total Aset</p>
        </div>
        <i class="bi bi-box-seam small-box-icon"></i>
      </div>
    </div>

    {{-- Aset Layak --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-success">
        <div class="inner">
          <h3>{{ $aset_layak ?? 0 }}</h3>
          <p>Aset Layak</p>
        </div>
        <i class="bi bi-check-circle small-box-icon"></i>
      </div>
    </div>

    {{-- Aset Tidak Layak --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-danger">
        <div class="inner">
          <h3>{{ $aset_tidak_layak ?? 0 }}</h3>
          <p>Aset Tidak Layak</p>
        </div>
        <i class="bi bi-x-circle small-box-icon"></i>
      </div>
    </div>

    {{-- Stok ATK Menipis --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-warning">
        <div class="inner">
          <h3>{{ $stok_rendah ?? 0 }}</h3>
          <p>Stok ATK Menipis</p>
        </div>
        <i class="bi bi-pencil-square small-box-icon"></i>
        </a>
      </div>
    </div>
  </div>

  {{-- NOTIFIKASI ASET BERMASALAH --}}
  <div class="row g-3 mt-3">
    <div class="col-lg-12">
      <div class="card shadow-sm">
        <div class="card-header">
          <h6 class="mb-0"><i class="bi bi-bell-fill"></i> Notifikasi Aset Bermasalah</h6>
        </div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush">
            @forelse($notif_aset as $n)
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

</div>
@endsection
