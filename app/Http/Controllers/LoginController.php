<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login user/admin
     */
    public function authenticate(Request $request)
    {
        // Validasi input
        $request->validate([
            'role' => 'required|in:admin,user', // Wajib pilih role
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Ambil kredensial tanpa role
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek apakah role yang dipilih sesuai dengan role di database
            if ($user->role !== $request->role) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak sesuai!');
            }

            // Redirect berdasarkan role
            return $user->role === 'admin'
                ? redirect()->route('admin.dashboard')->with('success', 'Login sebagai Admin berhasil!')
                : redirect()->route('user.dashboard')->with('success', 'Login sebagai User berhasil!');
        }

        // Jika login gagal
        return redirect()->route('login')->with('error', 'Email atau password salah.');
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Logout berhasil.');
    }

    /**
     * Menampilkan halaman registrasi
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi user
     */
    public function registrasi(Request $request)
{
    // Validasi input tanpa meminta role
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Buat pengguna baru dengan role yang sudah ditentukan 'user'
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user', // Role langsung diset ke 'user'
    ]);

    return redirect()->route('login')->with('message', 'Registrasi berhasil! Silakan login.');
}

}
