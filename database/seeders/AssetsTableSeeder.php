<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AssetsTableSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        $kategoriList = ['Elektronik', 'Perabot', 'Kendaraan', 'Alat Tulis', 'Perangkat Jaringan'];
        $lokasiList = ['Lab RPL', 'Ruang Guru', 'Gudang A', 'Kelas X RPL', 'Ruang TU'];
        $kondisiList = ['Baik', 'Rusak Ringan', 'Rusak Berat'];

        $data = [];

        for ($i = 0; $i < 30; $i++) {
            // ambil tahun antara 2015 - sekarang
            $tanggalPerolehan = Carbon::create(rand(2015, 2025), rand(1, 12), rand(1, 28));
            $umurTahun = Carbon::now()->year - $tanggalPerolehan->year;

            // ambil random kondisi
            $kondisi = $kondisiList[array_rand($kondisiList)];

            // tentukan kelayakan otomatis
            $kelayakan = match ($kondisi) {
                'Baik' => 'Layak Pakai',
                'Rusak Ringan' => 'Perlu Perbaikan',
                'Rusak Berat' => 'Tidak Layak',
            };

            $data[] = [
                'nama' => fake()->randomElement([
                    'Laptop Dell Inspiron',
                    'Proyektor Epson X200',
                    'Kursi Kantor Hitam',
                    'Meja Belajar Kayu',
                    'Router Mikrotik RB450',
                    'Printer Canon IP2770',
                    'Motor Operasional',
                    'Lemari Arsip Besi',
                    'Monitor LG 24"',
                    'Keyboard Logitech K120'
                ]),
                'kategori' => $kategoriList[array_rand($kategoriList)],
                'lokasi' => $lokasiList[array_rand($lokasiList)],
                'tanggal_perolehan' => $tanggalPerolehan,
                'umur_tahun' => $umurTahun,
                'kondisi' => $kondisi,
                'kelayakan' => $kelayakan,
                'description' => fake()->sentence(10),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('assets')->insert($data);
    }
}
