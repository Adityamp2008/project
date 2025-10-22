@extends('layouts.add') {{-- atau layouts.admin tergantung struktur kamu --}}
@section('title', 'Dashboard Super Admin')

@section('content')
<div class="container-fluid py-3">

  {{-- ==== HEADER ==== --}}
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Dashboard Super Admin</h4>
    <span class="text-muted">Selamat datang, {{ Auth::user()->name }}</span>
  </div>

  {{-- ==== INFO BOX ROW ==== --}}
  <div class="row g-3">
    <div class="col-md-3 col-sm-6">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $total_aset ?? '0' }}</h3>
          <p>Total Aset</p>
        </div>
        <div class="icon"><i class="bi bi-hdd-stack"></i></div>
        <a href="{{ route('assets.index') }}" class="small-box-footer">
          Lihat Detail <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>

    <div class="col-md-3 col-sm-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $aset_layak ?? '0' }}</h3>
          <p>Aset Layak</p>
        </div>
        <div class="icon"><i class="bi bi-check-circle-fill"></i></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $aset_tidak_layak ?? '0' }}</h3>
          <p>Aset Tidak Layak</p>
        </div>
        <div class="icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $stok_rendah ?? '0' }}</h3>
          <p>Stok ATK Menipis</p>
        </div>
        <div class="icon"><i class="bi bi-box-seam"></i></div>
      </div>
    </div>
  </div>

  {{-- ==== CHART SECTION ==== --}}
  <div class="row g-3 mt-3">
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

  {{-- ==== RIWAYAT PERBAIKAN TERAKHIR ==== --}}
  <div class="row mt-3">
    <div class="col-12">
      <div class="card shadow-sm">
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
                <td>{{ $r->nama_aset }}</td>
                <td>{{ $r->tanggal }}</td>
                <td>{{ $r->deskripsi }}</td>
                <td>Rp {{ number_format($r->biaya, 0, ',', '.') }}</td>
              </tr>
              @empty
              <tr><td colspan="5" class="text-center text-muted">Belum ada data perbaikan</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ==== SCRIPT CHART (ApexCharts) ==== --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const chart = new ApexCharts(document.querySelector("#chartKelayakan"), {
    chart: { type: 'donut', height: 300 },
    labels: ['Layak', 'Tidak Layak'],
    series: [{{ $aset_layak ?? 0 }}, {{ $aset_tidak_layak ?? 0 }}],
    colors: ['#198754', '#dc3545'],
    legend: { position: 'bottom' }
  });
  chart.render();
});
</script>
@endpush
@endsection
