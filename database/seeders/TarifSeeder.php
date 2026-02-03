<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tarif')->insert([
            [
                'nama_tarif' => 'R-1/TR 450VA',
                'tarif_per_kwh' => 169.00,
                'biaya_beban' => 0,
                'berlaku_dari' => '2026-01-01',
                'berlaku_sampai' => null,
                'keterangan' => null,
            ],
            [
                'nama_tarif' => 'R-1/TR 900VA',
                'tarif_per_kwh' => 1352.00,
                'biaya_beban' => 0,
                'berlaku_dari' => '2026-01-01',
                'berlaku_sampai' => null,
                'keterangan' => null,
            ],
            [
                'nama_tarif' => 'R-1/TR 1300VA',
                'tarif_per_kwh' => 1444.70,
                'biaya_beban' => 0,
                'berlaku_dari' => '2026-01-01',
                'berlaku_sampai' => null,
                'keterangan' => null,
            ],
            [
                'nama_tarif' => 'R-1/TR 2200VA',
                'tarif_per_kwh' => 1444.70,
                'biaya_beban' => 0,
                'berlaku_dari' => '2026-01-01',
                'berlaku_sampai' => null,
                'keterangan' => null,
            ],
            [
                'nama_tarif' => 'B-2/TR 2200VA',
                'tarif_per_kwh' => 1699.53,
                'biaya_beban' => 0,
                'berlaku_dari' => '2026-01-01',
                'berlaku_sampai' => null,
                'keterangan' => null,
            ],
        ]);
    }
}
