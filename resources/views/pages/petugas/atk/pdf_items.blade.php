<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data ATK</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #555;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Laporan Data ATK</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Batas Minimum</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category ?? '-' }}</td>
                <td>{{ $item->unit ?? '-' }}</td>
                <td>{{ $item->stock }}</td>
                <td>{{ $item->low_stock_threshold ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="text-align:right; margin-top:20px;">
        Dicetak pada: {{ now()->format('d-m-Y H:i') }}
    </p>
</body>
</html>
