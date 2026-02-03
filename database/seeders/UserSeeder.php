<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'nama_lengkap' => 'Administrator Sistem',
                'email' => 'admin@pln.co.id',
                'id_level' => 1,
                'is_active' => true,
            ],
            [
                'username' => 'operator1',
                'password' => Hash::make('operator123'),
                'nama_lengkap' => 'Budi Santoso',
                'email' => 'budi@pln.co.id',
                'id_level' => 2,
                'is_active' => true,
            ],
            [
                'username' => 'operator2',
                'password' => Hash::make('operator123'),
                'nama_lengkap' => 'Siti Nurhaliza',
                'email' => 'siti@pln.co.id',
                'id_level' => 2,
                'is_active' => true,
            ],
            [
                'username' => 'PEL001',
                'password' => Hash::make('password123'),
                'nama_lengkap' => 'Ahmad Subarjo',
                'email' => 'ahmad@email.com',
                'id_level' => 3,
                'is_active' => true,
            ],
            [
                'username' => 'PEL002',
                'password' => Hash::make('password123'),
                'nama_lengkap' => 'Rina Melati',
                'email' => 'rina@email.com',
                'id_level' => 3,
                'is_active' => true,
            ],
            [
                'username' => 'PEL003',
                'password' => Hash::make('password123'),
                'nama_lengkap' => 'Joko Widodo',
                'email' => 'joko@email.com',
                'id_level' => 3,
                'is_active' => true,
            ],
        ]);
    }
}
