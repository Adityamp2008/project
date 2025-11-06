<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Perbaikan Aset</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: center; }
        th { background-color: #eee; }
        h3 { text-align: center; }
    </style>
</head>
<body>
    <h3>Laporan Riwayat Perbaikan Aset</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Deskripsi</th>
                <th>Biaya</th>
                <th>Diperbaiki Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->asset->nama ?? '-' }}</td>
                    <td>{{ $r->asset->kategori->nama ?? '-' }}</td>
                    <td>{{ $r->tanggal_perbaikan ? \Carbon\Carbon::parse($r->tanggal_perbaikan)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $r->tanggal_selesai ? \Carbon\Carbon::parse($r->tanggal_selesai)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $r->description ?? '-' }}</td>
                    <td>Rp {{ number_format($r->biaya, 0, ',', '.') }}</td>
                    <td>{{ $r->diperbaiki_oleh ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
