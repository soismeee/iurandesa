<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\KategoriIuran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('123'),
        ]);

        KategoriIuran::create([
            'nama_kategori' => 'Kebersihan',
            'nominal' => 5000,
        ]);

        KategoriIuran::create([
            'nama_kategori' => 'Keamanan',
            'nominal' => 10000,
        ]);
    }
}
