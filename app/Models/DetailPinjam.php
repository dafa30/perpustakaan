<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPinjam extends Model
{
    use HasFactory;

    protected $table = 'detail_pinjam';
    // Karena ini composite primary key, kita tidak pakai $primaryKey ID tunggal
    public $incrementing = false; // Karena primary key bukan auto-incrementing integer
    protected $keyType = 'string'; // Karena primary key adalah array dari FKs
    protected $primaryKey = ['id_pinjam', 'id_buku']; // Composite primary key

    protected $fillable = [
        'id_pinjam',
        'id_buku',
        'tgl_kembali',
    ];

    protected $casts = [
        'tgl_kembali' => 'date',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_pinjam', 'id_pinjam');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
}