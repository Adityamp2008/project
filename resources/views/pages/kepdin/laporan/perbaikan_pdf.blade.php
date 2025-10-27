<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Perbaikan</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h3>Laporan Perbaikan</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Biaya</th>
                <th>Teknisi</th>
                <th>Tempat Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat as $r)
                <tr>
                    <td>{{ $r->tanggal }}</td>
                    <td>{{ $r->deskripsi }}</td>
                    <td>Rp{{ number_format($r->biaya, 0, ',', '.') }}</td>
                    <td>{{ $r->teknisi }}</td>
                    <td>{{ ucfirst(str_replace('_',' ',$r->asset_type)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h4>Total Biaya: Rp{{ number_format($total_biaya, 0, ',', '.') }}</h4>
</body>
</html>
