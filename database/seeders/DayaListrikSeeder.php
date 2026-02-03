<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DayaListrikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('daya_listrik')->insert([
            [
                'daya_watt' => 450,
                'id_tarif' => 1,
                'keterangan' => 'Rumah Tangga 450 VA',
            ],
            [
                'daya_watt' => 900,
                'id_tarif' => 2,
                'keterangan' => 'Rumah Tangga 900 VA',
            ],
            [
                'daya_watt' => 1300,
                'id_tarif' => 3,
                'keterangan' => 'Rumah Tangga 1300 VA',
            ],
            [
                'daya_watt' => 2200,
                'id_tarif' => 4,
                'keterangan' => 'Rumah Tangga 2200 VA',
            ],
            [
                'daya_watt' => 3500,
                'id_tarif' => 5,
                'keterangan' => 'Bisnis 3500 VA',
            ],
        ]);
    }
}
