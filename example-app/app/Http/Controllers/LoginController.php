<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // LOGIN BAGIAN SDM
            if ($credentials['email'] === 'bagsdm@gmail.com' && $credentials['password'] === '12345') {
                session([
                    'bagsdm_logged_in' => true,
                    'bagsdm_id' => 999,
                    'bagsdm_nama' => 'Bagian SDM'
                ]);
                return redirect()->intended('/dashboard-bagsdm');
            }

        // 1. Coba login sebagai admin menggunakan Auth Laravel
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // 2. Jika bukan admin, coba login sebagai karyawan (manual login)
        $karyawan = Karyawan::where('email', $credentials['email'])->first();

        if ($karyawan && $credentials['password'] === $karyawan->password) {
            // Simpan ID karyawan di session (bukan seluruh objek agar ringan)
            session([
                'karyawan_logged_in' => true,
                'karyawan_id' => $karyawan->id,
                'karyawan_nama' => $karyawan->nama
            ]);

            return redirect()->intended('/dashboard-karyawan');
        }

        // 3. Jika keduanya gagal
        return back()->with('loginError', 'Email atau Password yang Anda Input Salah, Mohon Periksa Kembali!');
    }

    public function logout()
    {   
         if (session()->has('bagsdm_logged_in')) {
            session()->forget(['bagsdm_logged_in', 'bagsdm_id']);
        }

        // Jika login sebagai karyawan
        if (session()->has('karyawan_logged_in')) {
            session()->forget(['karyawan_logged_in', 'karyawan_id']);
        } else {
            Auth::logout(); // logout admin
        }

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    }

    public function dashboardKaryawan()
    {
        // Cek apakah session valid
        if (!session('karyawan_logged_in') || !session('karyawan_id')) {
            return redirect('/login')->with('loginError', 'Silakan login terlebih dahulu.');
        }

        // Ambil data karyawan berdasarkan ID yang disimpan di session
        $karyawan = Karyawan::find(session('karyawan_id'));

        // Pastikan data karyawan valid
        if (!$karyawan) {
            return redirect('/login')->with('loginError', 'Data karyawan tidak ditemukan.');
        }

        return view('dashboard.karyawan', compact('karyawan'));
    }
    
}
