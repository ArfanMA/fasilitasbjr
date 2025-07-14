<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Master\Ruangan;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'ruangan_id',
        'deskripsi',
        'tgl_mulai',
        'tgl_selesai',
        'status', // Tambahkan status
    ];


    /**
     * Relasi ke tabel `users`
     * Peminjaman dilakukan oleh seorang user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi ke tabel `ruangan`
     * Setiap peminjaman berkaitan dengan satu ruangan.
     */
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id', 'id');
    }
}
