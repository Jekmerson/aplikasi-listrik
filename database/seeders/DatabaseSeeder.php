<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Run: php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        $this->call([
            LevelSeeder::class,
            UserSeeder::class,
            TarifSeeder::class,
            DayaListrikSeeder::class,
            PelangganSeeder::class,
            PenggunaanSeeder::class,  // Trigger akan auto-generate tagihan
            PembayaranSeeder::class,
        ]);
    }
}
