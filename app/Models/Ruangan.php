<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id'; // ✅ Pastikan Primary Key benar
    public $timestamps = false; // ✅ Jika tabel tidak punya created_at & updated_at
    protected $table = 'ruangan'; // Pastikan nama tabel sesuai
    protected $fillable = ['nama', 'deskripsi', 'foto', 'status'];

    /**
     * Relasi dengan Peminjaman (One to Many)
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'ruangan_id'); // Pastikan 'ruangan_id' ada di tabel peminjaman
    }
}
