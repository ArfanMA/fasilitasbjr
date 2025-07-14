@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Ruangan</h2>
    <form action="{{ route('master.ruangan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nama Ruangan</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('master.ruangan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
