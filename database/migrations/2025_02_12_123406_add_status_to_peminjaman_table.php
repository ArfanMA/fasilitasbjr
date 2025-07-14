// File: 2025_02_12_123406_add_status_to_peminjaman_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToPeminjamanTable extends Migration
{
    public function up()
    {
        // Jika kolom sudah ada, Anda bisa mengosongkan fungsi ini atau hapus file ini
    }

    public function down()
    {
        // Jika ingin menghapus kolom status ketika rollback (opsional)
        // Schema::table('peminjaman', function (Blueprint $table) {
        //     $table->dropColumn('status');
        // });
    }
}
