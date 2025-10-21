<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok ATK</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Laporan Stok ATK</h2>
    <p><strong>Periode:</strong> {{ $from }} s/d {{ $to }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Pengguna</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
                <tr>
                    <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $trx->item->name ?? '-' }}</td>
                    <td>{{ $trx->type === 'in' ? 'Masuk' : 'Keluar' }}</td>
                    <td>{{ $trx->quantity }}</td>
                    <td>{{ $trx->reference ?? '-' }}</td>
                    <td>{{ $trx->user->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
