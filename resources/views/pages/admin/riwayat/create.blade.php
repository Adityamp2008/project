@extends('layouts.add')
@section('title', 'Tambah Riwayat Perbaikan')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Riwayat Perbaikan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('riwayat.store') }}">
        @csrf

        <div class="mb-3">
            <label for="asset_type" class="form-label">Pilih Tempat Data</label>
            <select id="asset_type" name="asset_type" class="form-control" required>
                <option value="">-- Pilih Tempat Data --</option>
                <option value="aset_tetap">Aset Tetap</option>
                <option value="atk">ATK</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="item_id" class="form-label">Pilih Item</label>
            <select id="item_id" name="item_id" class="form-control" required>
                <option value="">-- Pilih Item --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="biaya">Biaya</label>
            <input type="number" name="biaya" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="teknisi">Teknisi</label>
            <input type="text" name="teknisi" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
document.getElementById('asset_type').addEventListener('change', function() {
    const type = this.value;
    const itemSelect = document.getElementById('item_id');

    if (!type) {
        itemSelect.innerHTML = '<option value="">-- Pilih Item --</option>';
        return;
    }

    itemSelect.innerHTML = '<option value="">Loading...</option>';

    fetch(`/admin/get-items/${type}`)
        .then(response => response.json())
        .then(data => {
            itemSelect.innerHTML = '<option value="">-- Pilih Item --</option>';
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.nama;
                itemSelect.appendChild(option);
            });
        })
        .catch(() => {
            itemSelect.innerHTML = '<option value="">Gagal memuat data</option>';
        });
});
</script>
@endsection
