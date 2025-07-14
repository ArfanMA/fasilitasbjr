<?php

namespace App\Repositories\Peminjaman;

use App\Contracts\Peminjaman\PeminjamanRepositoryInterface;
use App\Helpers\Helper;
use App\Models\Master\Ruangan;
use App\Models\Transaksi\Peminjaman;
use App\Models\Transaksi\PeminjamanItems;
use Carbon\Carbon;

class PeminjamanRepository implements PeminjamanRepositoryInterface{
    public function store($request)
    {
        $peminjaman                          = new Peminjaman();
        $peminjaman->no_transaksi_peminjaman = Helper::kode_transaksi(['pengunjung_id' => $request->input('pengunjung')]);
        $peminjaman->pengunjung_id           = $request->input('pengunjung');
        $peminjaman->is_sudah_kembali        = 1;
        $peminjaman->is_terlambat_kembali    = 0;
        $peminjaman->is_sudah_bayar          = $request->input('sudah_bayar');
        $peminjaman->tgl_mulai               = $request->input('tgl_mulai');
        $peminjaman->tgl_selesai             = $request->input('tgl_selesai');

        // Hapus perhitungan total_harga karena tidak lagi digunakan
        $peminjaman->save();

        return $peminjaman;
    }

    public function createPeminjamanItems($request, $peminjaman)
    {
        foreach($request->input('ruangan_id') as $key => $value){
            $create_peminjaman_item[$key] = PeminjamanItems::create([
                'peminjaman_id' => $peminjaman->id,
                'ruangan_id' => $value,
            ]);
        }

        return $create_peminjaman_item;
    }

    public function updateStatusRuangan($request)
    {
        foreach($request->input('ruangan_id') as $key => $value){
            $d_status_ruangan = [
                'is_tersedia' => 0, // Menandai ruangan tidak tersedia saat sedang dipinjam
            ];

            $update_status_ruangan[$key] = Ruangan::where('id', $value)->update($d_status_ruangan);
        }

        return $update_status_ruangan;
    }

    public function getDataById($data_id)
    {
        return Peminjaman::where('id', $data_id)->first();
    }
}
