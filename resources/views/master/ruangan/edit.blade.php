@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Ruangan</h4>
        </div>
        <div class="card-body">

            @if(isset($ruangan) && is_object($ruangan))
                <p>Ruangan ditemukan: {{ $ruangan->id }}</p>

                <form action="{{ route('master.ruangan.update', $ruangan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Nama Ruangan</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $ruangan->nama) }}" required>

                            @error('nama')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $ruangan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Foto Ruangan</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                            @error('foto')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>

                        @if(isset($ruangan->foto) && Storage::exists('public/' . $ruangan->foto))
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Foto Saat Ini</label>
                            <br>
                            <img src="{{ asset('storage/' . $ruangan->foto) }}" alt="Foto Ruangan" class="img-thumbnail" width="200">
                        </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('master.ruangan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            @else
                <div class="alert alert-danger">Ruangan tidak ditemukan.</div>
            @endif
        </div>
    </div>
</div>
@endsection
