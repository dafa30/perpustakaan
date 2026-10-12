<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_pinjam', function (Blueprint $table) {
            $table->foreignId('id_pinjam')->constrained('peminjaman', 'id_pinjam')->onDelete('cascade'); // FK Peminjaman
            $table->foreignId('id_buku')->constrained('buku', 'id_buku')->onDelete('cascade'); // FK Buku
            $table->date('tgl_kembali')->nullable(); // Tanggal buku dikembalikan
            $table->primary(['id_pinjam', 'id_buku']); // Composite primary key
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_pinjam');
    }
};