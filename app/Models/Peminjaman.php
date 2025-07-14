<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ruangan;


class Peminjaman extends Model
{
    protected $table = 'peminjaman'; 
    use HasFactory;

    protected $fillable = ['user_id', 'ruangan_id', 'tgl_mulai', 'tgl_selesai', 'keperluan', 'status'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Ruangan
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
