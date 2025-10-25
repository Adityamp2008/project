<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>{{ env('APP_NAME') }} | Dashboard Petugas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  {{-- Bootstrap & AdminLTE --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />
  <link rel="stylesheet" href="{{ asset('frontend/AdminLTE/dist/css/adminlte.css') }}" />
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
  <div class="app-wrapper">

    {{-- ==================== Navbar ==================== --}}
    <nav class="app-header navbar navbar-expand bg-body">
      <div class="container-fluid">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#">
              <i class="bi bi-list"></i>
            </a>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
              <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <li class="user-footer d-flex justify-content-between">
                <a href="#" class="btn btn-default btn-flat">Setting</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button 
                    type="submit" 
                    class="btn btn-default btn-flat"
                    onclick="return confirm('Yakin ingin logout?')">
                    Logout
                  </button>
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>

    {{-- ==================== Sidebar ==================== --}}
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <div class="sidebar-brand">
        <a href="{{ route('petugas.dashboard') }}" class="brand-link">
          <img src="{{ asset('frontend/AdminLTE/dist/assets/img/AdminLTELogo.png') }}" 
               alt="Logo" class="brand-image opacity-75 shadow" />
          <span class="brand-text fw-light">Petugas</span>
        </a>
      </div>

      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">

            {{-- Dashboard --}}
            <li class="nav-item">
              <a href="{{ route('petugas.dashboard') }}"
                 class="nav-link {{ Route::is('petugas.dashboard') ? 'active' : '' }}">
                <i class="nav-icon bi bi-speedometer2"></i>
                <p>Dashboard</p>
              </a>
            </li>

            {{-- Inventaris --}}
            @php
              $inventarisActive = Route::is('assets.*') || Route::is('atk.*');
            @endphp

            <li class="nav-item {{ $inventarisActive ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ $inventarisActive ? 'active' : '' }}">
                <i class="nav-icon bi bi-box-seam"></i>
                <p>
                  Inventaris
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('assets.index') }}"
                     class="nav-link {{ Route::is('assets.*') ? 'active' : '' }}">
                    <i class="bi bi-hdd-stack nav-icon"></i>
                    <p>Aset Tetap</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('atk.index') }}"
                     class="nav-link {{ Route::is('atk.*') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square nav-icon"></i>
                    <p>Barang ATK</p>
                  </a>
                </li>
              </ul>
            </li>

            {{-- Kelayakan Aset --}}
            <li class="nav-item">
              <a href="{{ route('kelayakanassets.index') }}"
                 class="nav-link {{ Route::is('kelayakanassets.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-clipboard-check"></i>
                <p>Kelayakan Aset</p>
              </a>
            </li>

            {{-- Laporan --}}
            <li class="nav-item">
              <a href="{{ route('laporan.report') }}"
                 class="nav-link {{ Route::is('laporan.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-journal-text"></i>
                <p>Laporan Pemakaian</p>
              </a>
            </li>

          </ul>
        </nav>
      </div>
    </aside>

    {{-- ==================== Main Content ==================== --}}
    <main class="app-main">
      @yield('content')
      @yield('script')
    </main>

    {{-- ==================== Footer ==================== --}}
    <footer class="app-footer">
      <div class="float-end d-none d-sm-inline">Dinas Arsip & Perpustakaan</div>
      <strong>© 2025 - Sistem Inventaris Aset</strong>
    </footer>
  </div>

  {{-- Scripts --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('frontend/AdminLTE/dist/js/adminlte.js') }}"></script>
</body>
</html>
