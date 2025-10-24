<?php

namespace App\Http\Controllers\petugas;

use App\Http\Controllers\Controller;
use App\Models\KelayakanAssets;

class KelayakanAssetsController extends Controller
{
    public function index()
    {
        // Ambil semua kelayakan lengkap dengan asset
        $kelayakanassets = KelayakanAssets::with('asset')->orderBy('id')->get();
        return view('pages.petugas.kelayakanassets.index', compact('kelayakanassets'));
    }
}
