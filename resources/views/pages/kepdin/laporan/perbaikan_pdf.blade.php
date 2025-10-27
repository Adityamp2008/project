<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Perbaikan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        h3 { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h3>LAPORAN RIWAYAT PERBAIKAN ASET</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Aset</th>
                <th>Deskripsi Perbaikan</th>
                <th>Biaya</th>
                <th>Diperbaiki Oleh</th>
                <th>Tanggal Perbaikan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayats as $key => $r)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $r->asset->nama ?? '-' }}</td>
                <td>{{ $r->deskripsi_perbaikan }}</td>
                <td>Rp {{ number_format($r->biaya, 0, ',', '.') }}</td>
                <td>{{ $r->diperbaiki_oleh }}</td>
                <td>{{ \Carbon\Carbon::parse($r->tanggal_perbaikan)->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
