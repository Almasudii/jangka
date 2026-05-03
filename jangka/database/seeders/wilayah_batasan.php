<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class wilayah_batasan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/wilayah_batasan_sampang.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
