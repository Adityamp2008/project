<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Kalau username sudah ada, lewati
        if (User::where('username', $row['username'])->exists()) {
            return null;
        }

        return new User([
            'name' => $row['name'],
            'username' => $row['username'],
            'role' => $row['role'],
            'password' => Hash::make($row['password']),
        ]);
    }
}
