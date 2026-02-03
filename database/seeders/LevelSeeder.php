<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('level')->insert([
            [
                'nama_level' => 'Admin',
                'deskripsi' => 'Administrator dengan akses penuh sistem',
            ],
            [
                'nama_level' => 'Operator',
                'deskripsi' => 'Operator PLN untuk input data',
            ],
            [
                'nama_level' => 'Pelanggan',
                'deskripsi' => 'Pelanggan listrik pascabayar',
            ],
        ]);
    }
}
