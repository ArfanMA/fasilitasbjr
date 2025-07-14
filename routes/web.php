<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Transaksi\PeminjamanController;
use App\Http\Controllers\Master\RuanganController;

// ------------------
// LOGIN & REGISTER ROUTES
// ------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('logged_in');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'registrasi'])->name('register_action');

// Redirect ke login jika membuka halaman utama
Route::get('/', function () {
    return redirect()->route('login');
});

// ------------------
// MIDDLEWARE AUTHENTICATION
// ------------------
Route::middleware(['auth'])->group(function () {

    // Redirect User berdasarkan Role
    Route::get('/dashboard', function () {
        return auth()->user()->role == 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // Dashboard untuk User & Admin
    Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    // PROFILE ROUTE
   Route::resource('profile', ProfileController::class)->only(['edit', 'update'])->names([
    'edit' => 'profile.edit',
    'update' => 'profile.update',
]);


    // MASTER - RUANGAN (Bisa diakses oleh semua user)
    Route::get('ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    // Ruangan khusus Admin (untuk CRUD ruangan)
    Route::middleware(['admin'])->prefix('master')->as('master.')->group(function () {
        Route::resource('ruangan', RuanganController::class);

    });

    // TRANSAKSI - PEMINJAMAN RUANGAN
    Route::prefix('transaksi')->as('transaksi.')->group(function () {
        // Untuk User: Daftar peminjaman
        Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        
        // Form peminjaman ruangan dengan dropdown pilihan ruangan
        Route::get('peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        
        // Simpan peminjaman
        Route::post('peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        
        // Opsional: Tampilan daftar ruangan (misalnya di sidebar)  
        Route::get('peminjaman/ruangan', [PeminjamanController::class, 'listRuangan'])->name('peminjaman.ruangan');
        
        // Untuk User: Jika ingin melihat daftar peminjaman dari user lain (jika diperlukan)
        Route::get('peminjaman/list', [PeminjamanController::class, 'listPeminjaman'])->name('peminjaman.list');

      // --- Tampilan Admin --- //
Route::middleware(['admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('peminjaman', [PeminjamanController::class, 'adminIndex'])->name('peminjaman.index');
    Route::post('peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::post('peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    // Route untuk menghapus peminjaman (HANYA ADMIN)
    Route::delete('peminjaman/{id}/hapus', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
});

        
        // Update (contoh: membatalkan peminjaman yang masih menunggu) untuk user
        Route::put('/peminjaman/{id}/batal', [PeminjamanController::class, 'batalkan'])->name('peminjaman.batal');

    });
});
