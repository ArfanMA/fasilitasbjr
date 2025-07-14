<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Ruangan;
use App\Models\Transaksi\Peminjaman;

class PeminjamanItems extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_items';

    protected $fillable = [
        'peminjaman_id',
        'ruangan_id',
        'tgl_mulai',
        'tgl_selesai',
        'deskripsi',
    ];

    /**
     * Relasi ke tabel `ruangan`
     */
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id', 'id');
    }

    /**
     * Relasi ke tabel `peminjaman`
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'id');
    }
}
