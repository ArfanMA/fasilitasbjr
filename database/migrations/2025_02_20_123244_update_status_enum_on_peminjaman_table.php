<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusEnumOnPeminjamanTable extends Migration
{
    public function up()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Ubah kolom status: ganti opsi 'dikembalikan' dengan 'selesai'
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])
                  ->default('menunggu')
                  ->change();
        });
    }
    
    public function down()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Kembalikan ke nilai semula (jika perlu)
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'dikembalikan'])
                  ->default('menunggu')
                  ->change();
        });
    }
}
