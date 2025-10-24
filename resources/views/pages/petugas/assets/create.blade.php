@extends('layouts.app')
@section('title', 'Tambah Aset')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Tambah Aset Baru</h2>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('assets.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Aset</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <input type="text" name="kategori" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Tanggal Perolehan</label>
                    <input type="date" name="tanggal_perolehan" id="tanggal_perolehan" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Umur (tahun)</label>
                    <input type="number" name="umur_tahun" id="umur_tahun" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Baik">Baik</option>
                        <option value="Cukup">Cukup</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="3" class="form-control"></textarea>
                </div>

                <div class="text-end">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('tanggal_perolehan').addEventListener('change', function() {
    const tgl = new Date(this.value);
    const now = new Date();
    let umur = now.getFullYear() - tgl.getFullYear();

    const mNow = now.getMonth();
    const mTgl = tgl.getMonth();
    if (mNow < mTgl || (mNow === mTgl && now.getDate() < tgl.getDate())) umur--;

    document.getElementById('umur_tahun').value = umur < 0 ? 0 : umur;
});
</script>
@endsection
