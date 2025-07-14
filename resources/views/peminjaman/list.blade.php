@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header halaman: judul + tombol create di pojok kanan -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Peminjaman Ruangan</h4>
        <!-- Tombol 'Pinjam Ruangan' di pojok kanan -->
        <a href="{{ route('transaksi.peminjaman.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Pinjam Ruangan
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Nama Ruangan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ optional($item->user)->name ?? 'User Tidak Ditemukan' }}</td>
                            <td>{{ optional($item->ruangan)->nama_ruangan ?? 'Ruangan Tidak Ditemukan' }}</td>
                            <td>{{ $item->tgl_mulai }}</td>
                            <td>{{ $item->tgl_selesai }}</td>
                            <td>
                                <span class="badge
                                    @if($item->status === 'menunggu') badge-warning
                                    @elseif($item->status === 'disetujui') badge-success
                                    @elseif($item->status === 'ditolak') badge-danger
                                    @elseif($item->status === 'dikembalikan') badge-info
                                    @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada peminjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
