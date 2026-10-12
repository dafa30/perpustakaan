<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // Nama tabel
    protected $primaryKey = 'id_user'; // Primary key
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'full_name',
        'nama_user',
        'password',
        'role', // Penting untuk menyimpan role
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Override untuk menggunakan 'nama_user' sebagai kredensial login
    public function findForPassport($nama_user)
    {
        return $this->where('nama_user', $nama_user)->first();
    }
    public function findForAuth($nama_user)
    {
        return $this->where('nama_user', $nama_user)->first();
    }

    // Helper methods untuk peran
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAnggota()
    {
        return $this->role === 'anggota';
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_user', 'id_user');
    }
}
