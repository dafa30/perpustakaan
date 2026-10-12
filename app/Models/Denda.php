<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'denda';
    protected $primaryKey = 'id_denda';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nominal',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_denda', 'id_denda');
    }
}