<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExcelExport;
use App\Helpers\Helper;
use App\Models\Master\Ruangan;
use App\Models\Transaksi\Peminjaman;
use App\Models\Transaksi\PeminjamanItems;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User as UserModel;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    private $title = 'Dashboard';
    private $header = 'Dashboard';

    /**
     * Dashboard untuk User & Admin
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return $this->userDashboard();
    }

    /**
     * Dashboard User
     */
    public function userDashboard()
    {
        // Menghitung total ruangan dan total user
        $totalRuangan = Ruangan::count();
        $totalUser = UserModel::count(); // Gunakan alias UserModel untuk menghindari konflik

        // Menjalankan Helper
        Helper::swal();

        // Mengambil data peminjaman
        $get_data_peminjaman = Peminjaman::get();
        $data_ruangan = [];

        // Menghitung jumlah peminjaman per hari dalam bulan ini
        $data_hari = [];
        $data_peminjam = [];
        $period = CarbonPeriod::create(Carbon::now()->firstOfMonth(), Carbon::now()->endOfMonth());

        foreach ($period as $key => $date) {
            $data_hari[$key] = $date->format('d');
            $data_peminjam[$key] = $get_data_peminjaman->where('tgl_mulai', $date->format('Y-m-d'))->count();
        }

        // Menghitung jumlah peminjaman ruangan berdasarkan ID
        $get_data_ruangan = PeminjamanItems::groupBy('ruangan_id')
            ->selectRaw('count(ruangan_id) as sum, ruangan_id')
            ->pluck('sum', 'ruangan_id');

        foreach ($get_data_ruangan as $key => $value) {
            $data_ruangan[$key] = [
                'name' => Ruangan::where('id', $key)->first()->nama ?? 'Tidak Diketahui',
                'y' => $value,
            ];
        }

        // Data yang dikirim ke tampilan
        $data = [
            'title' => $this->title,
            'header' => $this->header,
            'totalRuangan' => $totalRuangan,
            'totalUser' => $totalUser,
            'hari' => $data_hari,
            'peminjam' => $data_peminjam,
            'bulan' => ['Peminjaman Ruangan di Bulan ' . Carbon::now()->format('F')],
            'ruangan' => array_values($data_ruangan),
        ];

        return view('dashboard', $data);
    }

    /**
     * Dashboard Admin
     */
    public function adminDashboard()
    {
        $totalUser = UserModel::count();
        $totalRuangan = Ruangan::count();
        $totalPeminjaman = Peminjaman::count();

        return view('admin.dashboard', compact('totalUser', 'totalRuangan', 'totalPeminjaman'));
    }

    /**
     * Download Template Excel
     */
    public function downloadTemplateExcel()
    {
        return (new TemplateExcelExport())->download('template_excel.xlsx');
    }
}
