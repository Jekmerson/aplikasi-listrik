<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenggunaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Note: Trigger akan otomatis membuat tagihan untuk setiap penggunaan
     */
    public function run(): void
    {
        // Desember 2025
        DB::table('penggunaan')->insert([
            [
                'id_pelanggan' => 'PEL001',
                'bulan' => 12,
                'tahun' => 2025,
                'meter_awal' => 850,
                'meter_akhir' => 1000,
                'tanggal_catat' => '2025-12-28 10:00:00',
            ],
            [
                'id_pelanggan' => 'PEL002',
                'bulan' => 12,
                'tahun' => 2025,
                'meter_awal' => 1800,
                'meter_akhir' => 2000,
                'tanggal_catat' => '2025-12-28 10:15:00',
            ],
        ]);

        // Januari 2026
        DB::table('penggunaan')->insert([
            [
                'id_pelanggan' => 'PEL001',
                'bulan' => 1,
                'tahun' => 2026,
                'meter_awal' => 1000,
                'meter_akhir' => 1150,
                'tanggal_catat' => '2026-01-28 10:00:00',
            ],
            [
                'id_pelanggan' => 'PEL002',
                'bulan' => 1,
                'tahun' => 2026,
                'meter_awal' => 2000,
                'meter_akhir' => 2200,
                'tanggal_catat' => '2026-01-28 10:15:00',
            ],
            [
                'id_pelanggan' => 'PEL003',
                'bulan' => 1,
                'tahun' => 2026,
                'meter_awal' => 3000,
                'meter_akhir' => 3250,
                'tanggal_catat' => '2026-01-28 10:30:00',
            ],
            [
                'id_pelanggan' => 'PEL004',
                'bulan' => 1,
                'tahun' => 2026,
                'meter_awal' => 500,
                'meter_akhir' => 580,
                'tanggal_catat' => '2026-01-28 10:45:00',
            ],
            [
                'id_pelanggan' => 'PEL005',
                'bulan' => 1,
                'tahun' => 2026,
                'meter_awal' => 4000,
                'meter_akhir' => 4350,
                'tanggal_catat' => '2026-01-28 11:00:00',
            ],
        ]);
    }
}
