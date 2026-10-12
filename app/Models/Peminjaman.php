<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_pinjam';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'tgl_peminjaman',
        'lama_pinjam',
        'nominal_denda',
        'id_anggota',
        'id_denda',
        'id_user',
    ];

    protected $casts = [
        'tgl_peminjaman' => 'date',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function denda()
    {
        return $this->belongsTo(Denda::class, 'id_denda', 'id_denda');
    }

    public function detailPinjam()
    {
        return $this->hasMany(DetailPinjam::class, 'id_pinjam', 'id_pinjam');
    }
}