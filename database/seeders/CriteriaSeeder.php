<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $criteria = [
            ['code' => 'C1', 'name' => 'Kemampuan Musik'],
            ['code' => 'C2', 'name' => 'Ketahanan Fisik'],
            ['code' => 'C3', 'name' => 'Pengalaman'],
            ['code' => 'C4', 'name' => 'Koordinasi Tim'],
        ];

        foreach ($criteria as $criterion) {
            DB::table('criteria')->insert([
                'id' => Str::uuid(),
                'code' => $criterion['code'],
                'name' => $criterion['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
