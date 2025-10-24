<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AtkItem;
use App\Models\RiwayatPerbaikan;

class RiwayatPerbaikanController extends Controller
{

    public function index()
{
    $riwayat = \App\Models\RiwayatPerbaikan::with(['asset', 'atk'])->latest()->get();

    return view('pages.admin.riwayat.index', compact('riwayat'));
}

    public function create()
    {
        return view('pages.admin.riwayat.create');
    }

    public function getItems($type)
{
    if ($type === 'aset_tetap') {
        // pakai model dan kolom yang benar
        $items = \App\Models\Assets::select('id', 'nama as nama')->get();
    } elseif ($type === 'atk') {
        // pakai kolom 'name' dari AtkItem
        $items = \App\Models\AtkItem::select('id', 'name as nama')->get();
    } else {
        $items = [];
    }

    return response()->json($items);
}


    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'biaya' => 'required|numeric',
            'teknisi' => 'required|string',
            'asset_type' => 'required|in:aset_tetap,atk',
            'item_id' => 'required|integer',
        ]);

        $data = [
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'biaya' => $request->biaya,
            'teknisi' => $request->teknisi,
            'asset_type' => $request->asset_type,
        ];

        if ($request->asset_type === 'aset_tetap') {
            $data['asset_id'] = $request->item_id;
        } else {
            $data['atk_id'] = $request->item_id;
        }

        RiwayatPerbaikan::create($data);

        return redirect()->route('riwayat.create')->with('success', 'Riwayat perbaikan berhasil disimpan!');
    }

    
}
