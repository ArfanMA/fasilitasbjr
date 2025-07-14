@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Ajukan Peminjaman Ruangan</h4>
        </div>
        <div class="card-body">
            <!-- Tampilkan session error jika ada -->
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tampilkan error validasi -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transaksi.peminjaman.store') }}" method="POST">
                @csrf

                <!-- Dropdown Pilih Ruangan -->
                <div class="mb-3">
                    <label for="ruangan_id" class="form-label">Pilih Ruangan</label>
                    <select name="ruangan_id" id="ruangan_id" class="form-select" required>
                        <option value="">-- Pilih Ruangan --</option>
                        @foreach($ruangan as $r)
                            <option value="{{ $r->id }}">{{ $r->nama }}</option>
                        @endforeach
                    </select>
                </div>
            
                <!-- Tanggal Mulai -->
                <div class="mb-3">
                    <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" required>
                </div>

                <!-- Tanggal Selesai -->
                <div class="mb-3">
                    <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control" required>
                </div>

                <!-- Keperluan -->
                <div class="mb-3">
                    <label for="keperluan" class="form-label">Keperluan</label>
                    <textarea name="keperluan" id="keperluan" class="form-control" rows="3" placeholder="Jelaskan keperluan peminjaman" required></textarea>
                </div>

                <!-- Tombol di pojok kanan bawah -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Ajukan Peminjaman</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
