<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bayar tagihan Desember 2025
        DB::table('pembayaran')->insert([
            [
                'id_tagihan' => 1, // PEL001 Desember 2025
                'jumlah_bayar' => 202800.00, // 150 kWh x 1352
                'tanggal_bayar' => '2026-01-10 09:30:00',
                'metode_bayar' => 'Transfer',
                'keterangan' => 'Pembayaran via Transfer Bank',
            ],
            [
                'id_tagihan' => 2, // PEL002 Desember 2025
                'jumlah_bayar' => 270400.00, // 200 kWh x 1352
                'tanggal_bayar' => '2026-01-15 14:00:00',
                'metode_bayar' => 'QRIS',
                'keterangan' => 'Pembayaran via QRIS',
            ],
        ]);

        // Update status tagihan yang sudah dibayar
        DB::table('tagihan')
            ->whereIn('id_tagihan', [1, 2])
            ->update(['status_bayar' => 'Sudah Bayar']);
    }
}
