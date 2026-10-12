<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggota;
use Carbon\Carbon;

class AnggotaSeeder extends Seeder
{
    public function run()
    {
        // Data Anggota 1
        Anggota::create([
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Mawar No. 10, Jakarta',
            'no_hp' => '081234567890',
            'email' => 'budi.santoso@example.com',
            'tgl_lahir' => Carbon::parse('1990-05-15'),
            'tgl_daftar' => Carbon::now(),
        ]);

        // Data Anggota 2
        Anggota::create([
            'nama' => 'Siti Aminah',
            'alamat' => 'Jl. Melati No. 25, Bandung',
            'no_hp' => '081345678901',
            'email' => 'siti.aminah@example.com',
            'tgl_lahir' => Carbon::parse('1992-11-20'),
            'tgl_daftar' => Carbon::now(),
        ]);

        // Data Anggota 3
        Anggota::create([
            'nama' => 'Joko Susilo',
            'alamat' => 'Jl. Anggrek No. 5, Surabaya',
            'no_hp' => '081567890123',
            'email' => 'joko.susilo@example.com',
            'tgl_lahir' => Carbon::parse('1988-03-01'),
            'tgl_daftar' => Carbon::now(),
        ]);

        // Data Anggota 4
        Anggota::create([
            'nama' => 'Dewi Lestari',
            'alamat' => 'Jl. Kenanga Indah No. 12, Yogyakarta',
            'no_hp' => '081789012345',
            'email' => 'dewi.lestari@example.com',
            'tgl_lahir' => Carbon::parse('1995-07-22'),
            'tgl_daftar' => Carbon::now(),
        ]);

        // Data Anggota 5
        Anggota::create([
            'nama' => 'Rizky Pratama',
            'alamat' => 'Perumahan Damai Sentosa Blok C, Medan',
            'no_hp' => '081901234567',
            'email' => 'rizky.pratama@example.com',
            'tgl_lahir' => Carbon::parse('1991-09-10'),
            'tgl_daftar' => Carbon::now(),
        ]);
    }
}