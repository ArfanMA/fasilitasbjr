<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminIdToPeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('peminjaman', function (Blueprint $table) {
        $table->unsignedBigInteger('admin_id')->nullable()->after('status');
        $table->foreign('admin_id')->references('id')->on('users');
    });
}

public function down()
{
    Schema::table('peminjaman', function (Blueprint $table) {
        $table->dropForeign(['admin_id']);
        $table->dropColumn('admin_id');
    });
}

}
