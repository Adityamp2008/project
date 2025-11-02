<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>{{ env('APP_NAME') }} | @yield('title','Dashboard')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  {{-- Fonts, Icons, Styles --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('frontend/AdminLTE/dist/css/adminlte.css') }}">

  {{-- Chart & Map --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css">

  @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">

<div class="app-wrapper">

  {{-- Navbar --}}
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
            <li class="user-footer">
              <a href="#" class="btn btn-default btn-flat">Setting</a>

              <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-default btn-flat float-end"
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

  {{-- Sidebar --}}
  <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
      <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('frontend/AdminLTE/dist/assets/img/AdminLTELogo.png') }}"
             class="brand-image opacity-75 shadow">
        <span class="brand-text fw-light">{{ Auth::user()->name }}</span>
      </a>
    </div>

    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" id="navigation">

          <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
              <i class="nav-icon bi bi-speedometer2"></i> <p>Dashboard</p>
            </a>
          </li>

          {{-- Rooms --}}
          <li class="nav-item">
            <a class="nav-link {{ Route::is('rooms.*') ? 'active' : '' }}"
               href="{{ route('rooms.index') }}">
              <i class="nav-icon bi bi-house-door-fill"></i>
              <p>Manajemen Lokasi</p>
            </a>
          </li>

          {{-- Kategori --}}
          <li class="nav-item">
            <a class="nav-link {{ Route::is('kategori.*') ? 'active' : '' }}"
               href="{{ route('kategori.index') }}">
              <i class="nav-icon bi bi-tags-fill"></i>
              <p>Manajemen Kategori</p>
            </a>
          </li>

          {{-- Users --}}
          <li class="nav-item {{ Route::is('users.*') ? 'menu-open' : '' }}">
            <a class="nav-link {{ Route::is('users.*') ? 'active' : '' }}" href="#">
              <i class="nav-icon bi bi-people-fill"></i>
              <p>Manajemen Akun <i class="bi bi-chevron-right nav-arrow"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('users.index') }}"
                   class="nav-link {{ Route::is('users.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-person-gear"></i>
                  <p>Kelola Akun</p>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
    </div>
  </aside>

  <main class="app-main">
    @yield('content')
  </main>

  <footer class="app-footer">
    <div class="float-end d-none d-sm-inline">Selalu ada untuk warga</div>
    <strong>&copy; 2025 <a href="https://instagram/username">INSTAGRAM</a>.</strong>
  </footer>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('frontend/AdminLTE/dist/js/adminlte.js') }}"></script>

@stack('scripts')

</body>
</html>
