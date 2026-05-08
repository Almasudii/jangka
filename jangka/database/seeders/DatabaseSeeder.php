<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DesaSeeder::class,
            wilayah_batasan::class,
        ]);

        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'desa_id' => 1,
        ]);

        // Penduduk
        User::create([
            'name' => 'Penduduk',
            'email' => 'penduduk@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'penduduk',
            'desa_id' => 1,
        ]);

        $this->call([
            BeritaSeeder::class,
            FasilitasDesaSeeder::class,
        ]);
    }
}
