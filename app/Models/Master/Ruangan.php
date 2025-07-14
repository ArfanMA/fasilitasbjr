<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'id'; // Pastikan sesuai dengan database
    public $incrementing = true; // Jika ID auto-increment
    protected $keyType = 'int'; // Jika ID adalah integer
    public $timestamps = true; // Jika ada kolom created_at dan updated_at

    protected $fillable = ['nama', 'deskripsi', 'foto']; // Sesuaikan dengan kolom yang bisa diisi
}
