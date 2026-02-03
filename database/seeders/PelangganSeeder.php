<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelanggan')->insert([
            [
                'id_pelanggan' => 'PEL001',
                'nama_pelanggan' => 'Ahmad Subarjo',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'no_telepon' => '081234567890',
                'email' => 'ahmad@email.com',
                'id_daya_listrik' => 2, // 900VA
                'id_user' => 4,
                'tanggal_registrasi' => '2025-01-15',
                'status' => 'Aktif',
            ],
            [
                'id_pelanggan' => 'PEL002',
                'nama_pelanggan' => 'Rina Melati',
                'alamat' => 'Jl. Sudirman No. 45, Jakarta Selatan',
                'no_telepon' => '081298765432',
                'email' => 'rina@email.com',
                'id_daya_listrik' => 2, // 900VA
                'id_user' => 5,
                'tanggal_registrasi' => '2025-02-20',
                'status' => 'Aktif',
            ],
            [
                'id_pelanggan' => 'PEL003',
                'nama_pelanggan' => 'Joko Widodo',
                'alamat' => 'Jl. Gatot Subroto No. 78, Jakarta Barat',
                'no_telepon' => '081356789012',
                'email' => 'joko@email.com',
                'id_daya_listrik' => 3, // 1300VA
                'id_user' => 6,
                'tanggal_registrasi' => '2025-01-10',
                'status' => 'Aktif',
            ],
            [
                'id_pelanggan' => 'PEL004',
                'nama_pelanggan' => 'Susi Susanti',
                'alamat' => 'Jl. Ahmad Yani No. 99, Bandung',
                'no_telepon' => '082112345678',
                'email' => 'susi@email.com',
                'id_daya_listrik' => 1, // 450VA
                'id_user' => null,
                'tanggal_registrasi' => '2025-03-05',
                'status' => 'Aktif',
            ],
            [
                'id_pelanggan' => 'PEL005',
                'nama_pelanggan' => 'Bambang Pamungkas',
                'alamat' => 'Jl. Diponegoro No. 200, Surabaya',
                'no_telepon' => '083187654321',
                'email' => 'bambang@email.com',
                'id_daya_listrik' => 4, // 2200VA
                'id_user' => null,
                'tanggal_registrasi' => '2025-02-15',
                'status' => 'Aktif',
            ],
        ]);
    }
}
