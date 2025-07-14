@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3 text-primary">Daftar Peminjaman Ruangan (Admin)</h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-body p-3">
        <table class="table table-bordered table-hover align-middle">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
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
                    @forelse($peminjaman as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="text-center">
                                <img src="{{ $data->ruangan && $data->ruangan->foto ? asset('storage/' . $data->ruangan->foto) : asset('img/default-room.jpg') }}" 
                                     alt="Foto Ruangan" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                            </td>
                            <td>{{ $data->user->name ?? 'Tidak Diketahui' }}</td>
                            <td>{{ optional($data->ruangan)->nama ?? 'Ruangan Tidak Ditemukan' }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tgl_selesai)->format('d M Y') }}</td>
                            <td>{{ $data->keperluan ?? '-' }}</td>
                            <td>
                                <span class="badge badge-pill
                                    @if($data->status === 'menunggu') badge-warning
                                    @elseif($data->status === 'disetujui') badge-success
                                    @elseif($data->status === 'ditolak') badge-danger
                                    @elseif($data->status == 'dibatalkan') badge-secondary
                                    @elseif($data->status == 'selesai') badge-primary
                                    @endif">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>
                            <td>
                                @if($data->status === 'menunggu')
                                    <form action="{{ route('transaksi.admin.peminjaman.approve', $data->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">✔ Setujui</button>
                                    </form>
                                    <form action="{{ route('transaksi.admin.peminjaman.reject', $data->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">✖ Tolak</button>
                                    </form>
                                @elseif($data->status === 'disetujui')
                                    <form action="{{ route('transaksi.admin.peminjaman.kembalikan', $data->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-sm">🔄 Selesai</button>
                                    </form>
                                @endif

                                @if(in_array($data->status ?? '', ['ditolak', 'dikembalikan', 'dibatalkan', 'selesai']))
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete('{{ $data->id }}')">
                                        🗑 Hapus
                                    </button>

                                    <form id="delete-form-{{ $data->id }}" action="{{ route('transaksi.admin.peminjaman.destroy', $data->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data peminjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tambahkan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data peminjaman ini akan dihapus secara permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
