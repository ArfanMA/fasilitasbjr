<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('ruangan', function (Blueprint $table) {
            $table->enum('status', ['tersedia', 'dipinjam'])->default('tersedia')->after('foto');
        });
    }

    public function down()
    {
        Schema::table('ruangan', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
