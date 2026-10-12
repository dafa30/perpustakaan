<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Denda;

class DendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Denda::create(['nominal' => 1000]); // Denda Rp 1.000 per hari
        Denda::create(['nominal' => 1500]); // Denda Rp 1.500 per hari
        Denda::create(['nominal' => 2000]); // Denda Rp 2.000 per hari
        Denda::create(['nominal' => 500]);  // Denda Rp 500 per hari
        Denda::create(['nominal' => 2500]); // Denda Rp 2.500 per hari
    }
}