<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusEnumAddDibatalkan extends Migration
{
    public function up()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Ubah kolom status dengan menambahkan "dibatalkan"
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai', 'dibatalkan'])
                  ->default('menunggu')
                  ->change();
        });
    }

    public function down()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Rollback ke ENUM sebelumnya
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])
                  ->default('menunggu')
                  ->change();
        });
    }
}

