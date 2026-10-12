<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'tahun',
        'isbn',
        'tgl_input',
        'jml_halaman',
        'id_kategori',
    ];

    protected $casts = [
        'tgl_input' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'id_kategori', 'id_kategori');
    }

    public function detailPinjam()
    {
        return $this->hasMany(DetailPinjam::class, 'id_buku', 'id_buku');
    }
}  