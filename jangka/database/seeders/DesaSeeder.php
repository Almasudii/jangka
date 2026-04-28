<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Desa;

class DesaSeeder extends Seeder
{
    public function run()
    {
        $desas = [
            'Banyuanyar', 'Dalpenang', 'Gunung Maddah', 'Karang Dalem', 'Polagan',
            'Tanggumong', 'Panggung', 'Pasean', 'Taman Sareh', 'Kebanaran',
            'Karang Anyar', 'Camplong', 'Torjun', 'Jrengik', 'Omben',
            'Tambelangan', 'Ketapang', 'Sokobanah', 'Karang Penang'
        ];

        foreach ($desas as $nama) {
            Desa::create(['nama_desa' => $nama]);
        }
    }
}
