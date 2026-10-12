<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_pinjam'); // Primary key
            $table->date('tgl_peminjaman');
            $table->integer('lama_pinjam'); // dalam hari
            $table->decimal('nominal_denda', 10, 2)->nullable(); // Total denda untuk peminjaman ini

            $table->foreignId('id_anggota')->constrained('anggota', 'id_anggota')->onDelete('cascade'); // FK Anggota
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade'); // FK User (Admin/Petugas)
            $table->foreignId('id_denda')->nullable()->constrained('denda', 'id_denda')->onDelete('set null'); // FK Denda (jenis denda)

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
};