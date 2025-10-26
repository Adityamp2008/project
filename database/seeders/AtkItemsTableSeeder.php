<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AtkItemsTableSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        $categories = [
            'Alat Tulis',
            'Kertas',
            'Peralatan Kantor',
            'Elektronik Kantor',
            'ATK Lainnya'
        ];

        $units = ['pcs', 'box', 'rim', 'pak', 'unit'];

        $items = [
            'Pulpen Pilot Hitam',
            'Pulpen Biru Standard',
            'Pensil 2B Faber Castell',
            'Penghapus Joyko',
            'Penggaris 30cm',
            'Stapler Joyko',
            'Isi Staples No.10',
            'Kertas A4 80gsm',
            'Kertas F4 70gsm',
            'Map Snelhecter',
            'Lakban Bening',
            'Spidol Snowman Hitam',
            'Tinta Printer Epson 003',
            'Amplop Coklat Besar',
            'Kalkulator Casio',
            'Gunting Kantor Besi',
            'Cutter Tajima',
            'Sticky Notes Kecil',
            'Binder Clip 19mm',
            'Buku Agenda Kulit'
        ];

        $data = [];

        foreach ($items as $item) {
            $category = $categories[array_rand($categories)];
            $unit = $units[array_rand($units)];
            $stock = rand(0, 200);
            $threshold = rand(3, 15);

            $data[] = [
                'name' => $item,
                'description' => fake()->sentence(8),
                'unit' => $unit,
                'stock' => $stock,
                'low_stock_threshold' => $threshold,
                'category' => $category,
                'active' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('atk_items')->insert($data);
    }
}
