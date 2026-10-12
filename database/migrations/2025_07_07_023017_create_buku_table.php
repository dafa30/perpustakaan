<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id('id_buku'); // Primary key
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->integer('tahun');
            $table->string('isbn')->unique();
            $table->date('tgl_input');
            $table->integer('jml_halaman');
            $table->foreignId('id_kategori')->constrained('kategori_buku', 'id_kategori')->onDelete('cascade'); // FK
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('buku');
    }
};