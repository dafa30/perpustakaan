<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriBuku;

class KategoriBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        KategoriBuku::create(['kategori' => 'Fiksi']);
        KategoriBuku::create(['kategori' => 'Non-Fiksi']);
        KategoriBuku::create(['kategori' => 'Sains']);
        KategoriBuku::create(['kategori' => 'Sejarah']);
        KategoriBuku::create(['kategori' => 'Teknologi']); // Tambahan
    }
}