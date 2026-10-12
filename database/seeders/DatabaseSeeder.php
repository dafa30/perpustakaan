<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            KategoriBukuSeeder::class,
            AnggotaSeeder::class,
            BukuSeeder::class,
            DendaSeeder::class,
            PeminjamanSeeder::class, // <-- TAMBAHKAN INI
        ]);
    }
}