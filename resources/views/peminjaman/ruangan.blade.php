@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center text-bold">📌 Daftar Peminjaman Ruangan</h2>

    {{-- Menampilkan Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Menampilkan Pesan Error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tombol Tambah Peminjaman --}}
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('transaksi.peminjaman.create') }}" class="btn btn-primary">
            ➕ Pinjam Ruangan
        </a>
    </div>

    {{-- Tabel Daftar Peminjaman --}}
    <div class="table-responsive">
        <table class="table table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>NO</th>
                    <th>Foto</th>
                    <th>Nama Peminjam</th>
                    <th>Nama Ruangan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Keperluan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjaman as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-center">
                            <img src="{{ $p->ruangan && $p->ruangan->foto ? asset('storage/' . $p->ruangan->foto) : asset('img/default-room.jpg') }}" 
                                 alt="Foto Ruangan" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                        </td>
                        <td>{{ optional($p->user)->name ?? 'Tidak Ditemukan' }}</td>
                        <td>{{ optional($p->ruangan)->nama ?? 'Ruangan Tidak Ditemukan' }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tgl_mulai)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tgl_selesai)->format('d M Y') }}</td>
                        <td>{{ $p->keperluan }}</td>
                        <td>
                            {{-- Status dengan Warna yang Jelas --}}
                            <span class="badge 
                                @if($p->status == 'menunggu') bg-warning text-dark
                                @elseif($p->status == 'disetujui') bg-success 
                                @elseif($p->status == 'ditolak') bg-danger text-light
                                @elseif($p->status == 'dibatalkan') bg-dark text-light
                                @elseif($p->status == 'selesai') bg-primary text-white
                                @else bg-primary
                                @endif">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            {{-- Tombol Batalkan Hanya untuk Peminjam yang Statusnya Menunggu --}}
                            @if($p->status === 'menunggu' && Auth::user()->id === $p->user_id)
                                <form action="{{ route('transaksi.peminjaman.batal', $p->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-danger">❌ Batalkan</button>
                                </form>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
