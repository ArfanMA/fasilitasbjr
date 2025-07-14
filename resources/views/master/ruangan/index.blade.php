@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Data Ruangan</h2>
        <a href="{{ route('master.ruangan.create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus"></i> Tambah Ruangan
        </a>
    </div>

    <!-- Card untuk tabel -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th>Foto</th>
                            <th>Nama Ruangan</th>
                            <th>Deskripsi</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruangan as $key => $r)
                        <tr>
                            <td class="text-center fw-semibold">{{ $key + 1 }}</td>
                            <td class="text-center">
                                <img src="{{ $r->foto ? asset('storage/' . $r->foto) : asset('img/default-room.jpg') }}" 
                                     alt="Foto Ruangan" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                            </td>
                            <td>{{ $r->nama }}</td>
                            <td>{{ $r->deskripsi ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('master.ruangan.edit', $r->id) }}" class="btn btn-warning btn-sm me-2 shadow-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-danger btn-sm shadow-sm" onclick="confirmDelete('{{ $r->id }}')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                                <form id="delete-form-{{ $r->id }}" action="{{ route('master.ruangan.destroy', $r->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 untuk Konfirmasi Hapus -->
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin Ingin Menghapus Ruangan Ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
