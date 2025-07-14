<div class="col-md-6">
    <div class="form-group">
        <label for="no_transaksi_peminjaman"> No Transaksi </label>
        <input type="text" name="" value="{{ $data->no_transaksi_peminjaman }}" class="form-control" readonly id="no_transaksi_peminjaman" >
    </div>
    <div class="form-group">
        <label for="nama"> Nama Peminjam </label>
        <input type="text" name="" value="{{ $data->pengunjung->nama }}" class="form-control" readonly >
    </div>
    <div class="form-group">
        <label for="nama"> Lama Meminjam </label>
        <input type="text" name="" value="{{ \Carbon\Carbon::parse($data->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($data->tanggal_kembali)) }} Hari" class="form-control" readonly >
    </div>
    <div class="form-group">
        <label for="nama"> Total Tagihan </label>
        <input type="text" name="" value="Rp, {{ number_format($data->total_harga, 2) }} {{ $data->is_sudah_bayar == '0' ? 'Sudah Bayar' : 'Belum Bayar' }}" class="form-control" readonly >
    </div>
    <div class="form-group">
        <label for="nama"> Keterangan </label>
        @if ($data->is_sudah_kembali == '0')
        <textarea class="form-control" readonly> Transaksi Selesai</textarea>
        @else
        <textarea class="form-control" readonly> {{ \Carbon\Carbon::parse($data->tanggal_kembali) < \Carbon\Carbon::now() ? 'Telat Mengembalikan Pengunjung Tidak Bisa Meminjam Sebelum Diupdate Oleh Admin' : '-' }}</textarea>
        @endif
    </div>
    <div class="form-group">
        <label for="nama"> Biaya Lain Lain
            <p class="text-danger" data-toggle="tooltip" data-placement="top" title="Tagihan Ruangan Rusak">
                <i class="fas fa-fw fa-info"></i>
            </p>
        </label>
        <div id="biayaLainlain"></div>
    </div>
    @if ($data->is_sudah_kembali == '0')
        <a class="btn btn-warning bg-back" >Transaksi Sudah Diselesaikan</a>
    @else
        <a class="btn btn-danger bg-back" href="{{ route($route.'selesai_transaksi', ['transaksi_id' => $data->id]) }}">Selesai Transaksi</a>
    @endif
</div>
<div class="col-md-6">
    <label for="nama"> Daftar Ruangan </label>
    <div id="divListRuangan"></div>
    @foreach ($data->peminjaman_item as $item)
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <input type="text" name="" value="{{ $item->ruangan->nama }}" class="form-control" readonly >
            </div>
        </div>
        <div class="col-md-4 btnRuanganBermasalah{{ $item->ruangan_id }}">
            <button class="btn btn-md btn-danger btnRuanganBermasalah"  data-nama-ruangan="{{ $item->ruangan->nama }}" data-id-ruangan="{{ $item->ruangan->id }}" data-id-transaksi="{{ $data->id }}">Ruangan Bermasalah?</button>
        </div>
    </div>
    @endforeach
</div>
