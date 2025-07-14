<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('peminjaman_items', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('peminjaman_id');
        $table->unsignedBigInteger('ruangan_id');
        $table->date('tgl_mulai');
        $table->date('tgl_selesai');
        $table->text('deskripsi')->nullable();
        $table->timestamps();

        // Foreign Keys
        $table->foreign('peminjaman_id')->references('id')->on('peminjaman')->onDelete('cascade');
        $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('cascade');
    });
}

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjaman_items');
    }
}
