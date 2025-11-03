<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Jalankan seeder akun admin.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hris.com'], // cek biar gak dobel
            [
                'name' => 'Admin HRIS',
                'password' => Hash::make('password'), // password = password
                'role' => 'admin',
            ]
        );
    }
}
