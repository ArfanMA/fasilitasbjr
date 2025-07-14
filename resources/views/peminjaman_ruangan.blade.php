<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman Ruangan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Data Pinjam Ruangan</h2>
        <a href="#" class="btn btn-primary mb-3">+ Tambah Data</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Ruangan</th>
                    <th>Tgl Mulai</th>
                    <th>Tgl Selesai</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Gedung A</td>
                    <td>2021-04-07</td>
                    <td>2021-04-20</td>
                    <td><span class="badge bg-success">approve</span></td>
                    <td>
                        <button class="btn btn-danger btn-sm">Kembalikan</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Perpustakaan</td>
                    <td>2021-04-07</td>
                    <td>2021-04-17</td>
                    <td><span class="badge bg-warning">menunggu</span></td>
                    <td>
                        <button class="btn btn-danger btn-sm">Tolak</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
