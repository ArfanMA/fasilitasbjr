@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Pilih Ruangan yang Ingin Dipinjam</h4>

    @if($ruangans->isEmpty())
        <p>Belum ada ruangan yang tersedia untuk dipinjam.</p>
    @else
        <div class="card shadow-sm">
            <div class="card-body">
                @foreach($ruangans as $ruangan)
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <strong>{{ $ruangan->nama }}</strong>
                        <p>{{ $ruangan->deskripsi }}</p>
                        <p>Status: {{ $ruangan->status }}</p>
                    </div>
                    
                    <div>
                        <a href="{{ route('transaksi.peminjaman.create', $ruangan->id) }}" class="btn btn-primary">Pinjam</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Daftar Peminjaman yang sudah ada -->
    @if($peminjaman->isNotEmpty())
        <h5 class="mt-4">Peminjaman yang Sedang Aktif</h5>
        <div class="card shadow-sm">
            <div class="card-body">
                @foreach($peminjaman as $pinjam)
                <div class="mb-4">
                    <strong>{{ $pinjam->ruangan->nama }}</strong><br>
                    {{ $pinjam->user->name }} - {{ $pinjam->keperluan }}<br>
                    Tanggal Mulai: {{ $pinjam->tgl_mulai }} | Tanggal Selesai: {{ $pinjam->tgl_selesai }}<br>
                    Status: {{ $pinjam->status }}
                </div>
                @endforeach
            </div>
        </div>
    @else
        <p>Tidak ada peminjaman yang aktif saat ini.</p>
    @endif
</div>
@endsection
