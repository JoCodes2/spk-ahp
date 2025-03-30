<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus semua data di tabel criteria
        DB::table('criteria')->truncate();

        // Data dengan ID UUID acak
        $criteria = [
            ['id' => 'a1b2c3d4-e5f6-7890-abcd-ef1234567890', 'code' => 'C1', 'name' => 'Kemampuan Musik'],
            ['id' => 'b2c3d4e5-f678-9012-abcd-ef2345678901', 'code' => 'C2', 'name' => 'Ketahanan Fisik'],
            ['id' => 'c3d4e5f6-7890-1234-abcd-ef3456789012', 'code' => 'C3', 'name' => 'Pengalaman'],
            ['id' => 'd4e5f678-9012-3456-abcd-ef4567890123', 'code' => 'C4', 'name' => 'Koordinasi Tim'],
        ];

        // Insert data langsung ke tabel
        DB::table('criteria')->insert($criteria);

        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
