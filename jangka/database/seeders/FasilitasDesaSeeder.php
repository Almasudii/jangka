<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasDesaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('fasilitas_desa')->insert([
            [
                'thumbnail' => null,
                'deskripsi' => 'Balai desa digunakan sebagai pusat pelayanan administrasi, musyawarah, dan kegiatan resmi masyarakat desa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'thumbnail' => null,
                'deskripsi' => 'Puskesmas desa menjadi tempat pelayanan kesehatan dasar bagi masyarakat, seperti pemeriksaan umum, imunisasi, dan konsultasi kesehatan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'thumbnail' => null,
                'deskripsi' => 'Sekolah dasar desa berfungsi sebagai fasilitas pendidikan dasar bagi anak-anak di lingkungan desa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'thumbnail' => null,
                'deskripsi' => 'Masjid desa digunakan sebagai tempat ibadah, kegiatan keagamaan, dan pembinaan masyarakat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'thumbnail' => null,
                'deskripsi' => 'Lapangan desa dimanfaatkan untuk kegiatan olahraga, upacara, acara masyarakat, dan kegiatan pemuda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'thumbnail' => null,
                'deskripsi' => 'Pos keamanan lingkungan berfungsi sebagai tempat pemantauan keamanan dan koordinasi ronda warga.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}