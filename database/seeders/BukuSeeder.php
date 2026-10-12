<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Carbon\Carbon;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Pastikan kategori sudah ada atau buat jika belum
        $fiksi = KategoriBuku::firstOrCreate(['kategori' => 'Fiksi'])->id_kategori;
        $sains = KategoriBuku::firstOrCreate(['kategori' => 'Sains'])->id_kategori;
        $sejarah = KategoriBuku::firstOrCreate(['kategori' => 'Sejarah'])->id_kategori;
        $teknologi = KategoriBuku::firstOrCreate(['kategori' => 'Teknologi'])->id_kategori;
        $nonFiksi = KategoriBuku::firstOrCreate(['kategori' => 'Non-Fiksi'])->id_kategori;


        Buku::create([
            'judul' => 'Laskar Pelangi',
            'pengarang' => 'Andrea Hirata',
            'penerbit' => 'Bentang Pustaka',
            'tahun' => 2005,
            'isbn' => '978-979-3062-79-1',
            'tgl_input' => Carbon::now(),
            'jml_halaman' => 320,
            'id_kategori' => $fiksi,
        ]);
        Buku::create([
            'judul' => 'Cosmos',
            'pengarang' => 'Carl Sagan',
            'penerbit' => 'Ballantine Books',
            'tahun' => 1980,
            'isbn' => '978-0-345-53943-4',
            'tgl_input' => Carbon::now(),
            'jml_halaman' => 384,
            'id_kategori' => $sains,
        ]);
        Buku::create([
            'judul' => 'Sapiens: A Brief History of Humankind',
            'pengarang' => 'Yuval Noah Harari',
            'penerbit' => 'Harper Perennial',
            'tahun' => 2014,
            'isbn' => '978-0-06-231609-7',
            'tgl_input' => Carbon::now(),
            'jml_halaman' => 443,
            'id_kategori' => $sejarah,
        ]);
        Buku::create([
            'judul' => 'Atomic Habits',
            'pengarang' => 'James Clear',
            'penerbit' => 'Penguin',
            'tahun' => 2018,
            'isbn' => '978-0-7352-1129-2',
            'tgl_input' => Carbon::now(),
            'jml_halaman' => 320,
            'id_kategori' => $nonFiksi,
        ]);
        Buku::create([
            'judul' => 'The Martian',
            'pengarang' => 'Andy Weir',
            'penerbit' => 'Crown Publishing Group',
            'tahun' => 2011,
            'isbn' => '978-0-8041-3902-1',
            'tgl_input' => Carbon::now(),
            'jml_halaman' => 369,
            'id_kategori' => $fiksi,
        ]);
    }
}