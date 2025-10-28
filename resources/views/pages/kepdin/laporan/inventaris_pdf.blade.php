<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Inventaris</title>
    <style>
        body { font-family: sans-serif; }
        h3, h5 { margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; font-size: 12px; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3>Laporan Inventaris</h3>

    {{-- ===================== ASET TETAP ===================== --}}
    @if($assetType == '' || $assetType == 'aset_tetap')
        <h5>Aset Tetap</h5>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Kondisi</th>
                    <th>Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $asetItems = $items->where('jenis', 'Aset Tetap');
                @endphp
                @forelse($asetItems as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->kondisi }}</td>
                        <td>{{ $item->lokasi }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;">Tidak ada data aset tetap</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    {{-- ===================== ATK ===================== --}}
    @if($assetType == '' || $assetType == 'atk')
        <h5>Alat Tulis Kantor (ATK)</h5>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $atkItems = $items->where('jenis', 'ATK');
                @endphp
                @forelse($atkItems as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->stok }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" style="text-align:center;">Tidak ada data ATK</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

</body>
</html>
