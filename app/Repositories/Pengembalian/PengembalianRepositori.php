<?php

namespace App\Repositories\Pengembalian;

use App\Contracts\Pengembalian\PengembalianRepositoriInterface;
use App\Models\Master\Ruangan;
use App\Models\Master\Pengunjung;
use App\Models\Transaksi\Peminjaman;
use App\Models\Transaksi\PeminjamanBermasalah;
use App\Models\Transaksi\PeminjamanItems;
use Carbon\Carbon;

class PengembalianRepositori implements PengembalianRepositoriInterface{
    public function getDataByKode($kode)
    {
        return Peminjaman::where('no_transaksi_peminjaman', $kode)->first();
    }

    public function getDataById($data_id)
    {
        return Peminjaman::where('id', $data_id)->first();
    }

    public function updateTransaksiItems($transakasi_id)
    {
        // Mengubah status ruangan menjadi tersedia kembali setelah pengembalian
        $update_data_ruangan = Ruangan::whereIn('id', PeminjamanItems::where('peminjaman_id', $transakasi_id)->pluck('ruangan_id')->toArray())->update([
            'is_tersedia' => 1
        ]);
        return $update_data_ruangan;
    }

    public function updateTransaksi($transakasi)
    {
        $set_data_peminjaman = [
            'is_sudah_kembali' => 1, // Menandakan peminjaman telah dikembalikan
            'tanggal_pengembalian' => Carbon::now(),
        ];

        if (Carbon::parse($transakasi->tgl_selesai) < Carbon::now()->format('Y-m-d')) {
            $set_data_peminjaman['is_terlambat_kembali'] = 1;

            $set_data_pengunjung = [
                'is_boleh_pinjam' => 0 // Pengunjung tidak bisa meminjam lagi jika terlambat
            ];
            $update_data_pengunjung = Pengunjung::where('id', $transakasi->pengunjung_id)->update($set_data_pengunjung);
        }

        $update_transakasi = $transakasi->update($set_data_peminjaman);
        return $update_transakasi;
    }

    public function sendDenda($request)
    {
        $set_data_peminjaman_bermasalah = [
            'ruangan_id'   => $request['id_ruangan'],
            'transaksi_id' => $request['id_transaksi'],
            'denda'        => $request['denda'],
            'keterangan'   => $request['keterangan'],
        ];

        return PeminjamanBermasalah::create($set_data_peminjaman_bermasalah);
    }

    public function getBiayaLain($transaksi_id)
    {
        $query = PeminjamanBermasalah::where('transaksi_id', $transaksi_id['id_transaksi'])
            ->join('ruangan', 'ruangan.id', 'peminjaman_bermasalah.ruangan_id')
            ->select('ruangan.nama as nama_ruangan', 'peminjaman_bermasalah.denda', 'peminjaman_bermasalah.keterangan', 'peminjaman_bermasalah.ruangan_id')
            ->get();

        $data = [];
        foreach ($query as $key => $value) {
            $data[$key] = [
                'nama_ruangan' => $value->nama_ruangan,
                'keterangan'   => $value->keterangan,
                'denda'        => number_format($value->denda, 2),
                'total'        => $value->denda,
                'ruangan_id'   => $value->ruangan_id,
            ];
        }

        return $data;
    }
}
