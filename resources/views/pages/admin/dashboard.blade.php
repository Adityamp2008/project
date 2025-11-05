@extends('layouts.add')
@section('title', 'Dashboard Admin - Manajemen Akun')

@section('content')
<div class="container-fluid py-3">

  {{-- === HEADER === --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Dashboard Admin</h4>
    <small class="text-muted">Selamat datang, {{ Auth::user()->name }}</small>
  </div>

  {{-- === STATISTIK PENGGUNA === --}}
  <div class="row g-3">
    {{-- Total Pengguna --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-primary shadow-sm">
        <div class="inner">
          <h3>{{ $total_users ?? 0 }}</h3>
          <p>Total Pengguna</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
          <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 
          1.34-3 3 1.34 3 3 3zM8 11c1.66 0 2.99-1.34 
          2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 
          3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 
          14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 
          1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
        </svg>
      </div>
    </div>

    {{-- Admin --}}
    {{-- <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-success shadow-sm">
        <div class="inner">
          <h3>{{ $total_admin ?? 0 }}</h3>
          <p>Admin</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 
          1.79-4 4 1.79 4 4 4zm0 2c-2.67 
          0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
      </div>
    </div> --}}

    {{-- Petugas --}}
    {{-- <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-warning shadow-sm">
        <div class="inner">
          <h3>{{ $total_petugas ?? 0 }}</h3>
          <p>Petugas</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.21 0 4-1.79 
          4-4s-1.79-4-4-4-4 1.79-4 
          4 1.79 4 4 4zm0 2c-2.67 0-8 
          1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
      </div>
    </div> --}}

    {{-- Kepdin --}}
    {{-- <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-danger shadow-sm">
        <div class="inner">
          <h3>{{ $total_kepdin ?? 0 }}</h3>
          <p>Kepala Dinas</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.21 0 4-1.79 
          4-4s-1.79-4-4-4-4 1.79-4 
          4 1.79 4 4 4zm0 2c-2.67 0-8 
          1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
      </div>
    </div> --}}
    
    {{-- Ruangan --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-info shadow-sm">
        <div class="inner">
          <h3>{{ $total_rooms ?? 0 }}</h3>
          <p>Total Ruangan</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
          <path d="M4 4h16v16H4V4zm2 2v12h12V6H6zm3 2h2v2H9V8zm4 0h2v2h-2V8zm-4 4h2v2H9v-2zm4 0h2v2h-2v-2z"/>
        </svg>
      </div>
    </div>

    {{-- Kategori --}}
    <div class="col-md-3 col-sm-6">
      <div class="small-box text-bg-secondary shadow-sm">
        <div class="inner">
          <h3>{{ $total_categories ?? 0 }}</h3>
          <p>Total Kategori</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
          <path d="M3 6l3-3h12l3 3v12l-3 3H6l-3-3V6zm3 0v12h12V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
        </svg>
      </div>
    </div>

    
    
  </div>
  
  
  
  

  {{-- Tombol Navigasi ke Manajemen Akun --}}


</div>
@endsection
