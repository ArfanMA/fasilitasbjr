<!-- resources/views/peminjaman/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Daftar Peminjaman Anda</h4>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ruangan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Keperluan</th> <!-- Tambahkan kolom Keperluan -->
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ optional($data->ruangan)->nama ?? 'Ruangan Tidak Ditemukan' }}</td>
                            <td>{{ $data->tgl_mulai }}</td>
                            <td>{{ $data->tgl_selesai }}</td>
                            <td>{{ $data->keperluan ?? 'Tidak ada keperluan' }}</td> <!-- Menampilkan Keperluan -->
                            <td>{{ ucfirst($data->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
