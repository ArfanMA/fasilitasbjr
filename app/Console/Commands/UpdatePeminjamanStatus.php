<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use Carbon\Carbon;

class UpdatePeminjamanStatus extends Command
{
    protected $signature = 'peminjaman:update-status';
    protected $description = 'Update status peminjaman menjadi "Selesai" jika tanggal selesai sudah lewat';

    public function handle()
    {
        // Ambil semua peminjaman yang masih aktif dan sudah melewati tanggal selesai
        $peminjaman = Peminjaman::where('status', '!=', 'Selesai')
            ->whereDate('tgl_selesai', '<', Carbon::today()) // Jika tanggal selesai sudah lewat hari ini
            ->update(['status' => 'Selesai']); // Ubah status menjadi Selesai

        $this->info("Status peminjaman diperbarui.");
    }
}
