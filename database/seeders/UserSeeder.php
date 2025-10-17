<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'name' => 'Petugas User',
            'username' => 'petugas',
            'role' => 'petugas',
            'password' => Hash::make('petugas123'),
        ]);

        User::create([
            'name' => 'Kepala Dinas',
            'username' => 'kepdin',
            'role' => 'kepdin',
            'password' => Hash::make('kepdin123'),
        ]);
    }
}
