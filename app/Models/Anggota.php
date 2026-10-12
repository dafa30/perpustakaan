<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota'; 
    protected $primaryKey = 'id_anggota'; 
    public $incrementing = true; 
    protected $keyType = 'int'; 
    
    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'email',
        'tgl_lahir',
        'tgl_daftar',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'tgl_daftar' => 'date',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }
}