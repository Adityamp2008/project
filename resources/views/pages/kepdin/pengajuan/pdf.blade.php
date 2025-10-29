<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengajuan Stok ATK</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #ddd; }
        h3 { text-align: center; margin-bottom: 5px; }
    </style>
</head>
<body>
    <h3>Daftar Pengajuan Stok ATK</h3>
    <p><strong>Tanggal Cetak:</strong> {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Diajukan Oleh</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuan as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                    <td>{{ $p->item->name ?? '-' }}</td>
                    <td>{{ $p->jenis === 'in' ? 'Penambahan' : 'Pengurangan' }}</td>
                    <td>{{ $p->jumlah }}</td>
                    <td>{{ $p->keterangan ?? '-' }}</td>
                    <td>{{ $p->user->name ?? '-' }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Tidak ada data pengajuan stok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
