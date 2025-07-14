<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar semua peminjaman, termasuk user dan ruangan.
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'ruangan'])->latest()->get();
        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Menampilkan form peminjaman dengan daftar ruangan yang tersedia.
     */
    public function create()
    {
        $ruangan = Ruangan::where('status', 'tersedia')->get();
        return view('peminjaman.create', compact('ruangan'));
    }

    /**
     * Menampilkan daftar ruangan yang tersedia dan peminjaman.
     */
    public function listRuangan()
    {
        $ruangan = Ruangan::where('status', 'tersedia')->get();
        $peminjaman = Peminjaman::with('ruangan')->get();
        return view('peminjaman.ruangan', compact('ruangan', 'peminjaman'));
    }

    /**
     * Menampilkan daftar peminjaman dengan status "menunggu" atau "disetujui".
     */
    public function listPeminjaman()
    {
        $peminjaman = Peminjaman::with(['user', 'ruangan'])
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->latest()
            ->get();
        return view('peminjaman.list', compact('peminjaman'));
    }

    /**
     * Menyimpan peminjaman ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ruangan_id'  => 'required|exists:ruangan,id',
            'tgl_mulai'   => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'keperluan'   => 'required|string|max:255',
        ]);

        $ruangan = Ruangan::where('id', $request->ruangan_id)->where('status', 'tersedia')->first();
        if (!$ruangan) {
            return redirect()->back()->with('error', 'Ruangan tidak tersedia.');
        }

        Peminjaman::create([
            'user_id'     => Auth::id(),
            'ruangan_id'  => $request->ruangan_id,
            'tgl_mulai'   => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'keperluan'   => $request->keperluan,
            'status'      => 'menunggu',
        ]);

        $ruangan->update(['status' => 'dipinjam']);

        return redirect()->route('transaksi.peminjaman.index')->with('success', 'Peminjaman berhasil diajukan!');
    }

    /**
     * Admin - Menampilkan daftar peminjaman.
     */
    public function adminIndex()
    {
        $peminjaman = Peminjaman::with(['user', 'ruangan'])->latest()->get();
        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Admin - Menyetujui peminjaman.
     */
    public function approve($id)
    {
        $peminjaman = Peminjaman::where('id', $id)->where('status', 'menunggu')->first();
        if (!$peminjaman) {
            return back()->with('error', 'Peminjaman ini tidak bisa diproses.');
        }

        $peminjaman->update(['status' => 'disetujui', 'admin_id' => Auth::id()]);

        return back()->with('success', 'Peminjaman disetujui oleh Admin!');
    }

    /**
     * Admin - Menolak peminjaman.
     */
    public function reject($id)
    {
        $peminjaman = Peminjaman::where('id', $id)->where('status', 'menunggu')->first();
        if (!$peminjaman) {
            return back()->with('error', 'Peminjaman ini tidak bisa diproses.');
        }

        $peminjaman->update(['status' => 'ditolak', 'admin_id' => Auth::id()]);

        // Mengembalikan status ruangan ke "tersedia"
        Ruangan::where('id', $peminjaman->ruangan_id)->update(['status' => 'tersedia']);

        return back()->with('error', 'Peminjaman ditolak oleh Admin.');
    }

    /**
     * User/Admin - Mengembalikan ruangan yang dipinjam.
     */
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::where('id', $id)->where('status', 'disetujui')->first();
        if (!$peminjaman) {
            return back()->with('error', 'Ruangan ini belum bisa dikembalikan.');
        }

        $peminjaman->update(['status' => 'selesai']);

        Ruangan::where('id', $peminjaman->ruangan_id)->update(['status' => 'tersedia']);

        return back()->with('info', 'Peminjaman telah diselesaikan.');
    }
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
    
        // Pastikan hanya admin yang bisa menghapus
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus peminjaman.');
        }
    
        $peminjaman->delete(); // Hapus data dari database
    
        return redirect()->back()->with('success', 'Data peminjaman berhasil dihapus.');
    }
    
    /**
     * Membatalkan peminjaman jika status masih "menunggu".
     */
    public function batalkan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
    
        // Cek apakah user yang login adalah peminjamnya
        if (Auth::user()->id !== $peminjaman->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk membatalkan peminjaman ini.');
        }
    
        // Pastikan status masih "menunggu"
        if ($peminjaman->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Peminjaman sudah diproses dan tidak bisa dibatalkan.');
        }
    
        // Lakukan pembatalan
        $peminjaman->status = 'dibatalkan';
        $peminjaman->save();
    
        return redirect()->back()->with('success', 'Peminjaman berhasil dibatalkan.');
    }

}
