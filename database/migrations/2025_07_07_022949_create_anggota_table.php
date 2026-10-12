<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id('id_anggota'); // Primary key
            $table->string('nama');
            $table->string('alamat')->nullable();
            $table->string('no_hp')->unique();
            $table->string('email')->unique();
            $table->date('tgl_lahir');
            $table->date('tgl_daftar');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota');
    }
};