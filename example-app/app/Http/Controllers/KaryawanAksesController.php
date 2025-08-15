<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;


class KaryawanAksesController extends Controller
{
    public function dashboard()
{
    if (!session()->has('karyawan_logged_in')) {
        return redirect()->route('login');
    }

    // Gunakan Eloquent model berdasarkan ID dari session
    $karyawan = Karyawan::find(session('karyawan_id'));

    if (!$karyawan) {
        return redirect()->route('login')->withErrors('Data karyawan tidak ditemukan.');
    }

    return view('dashboard.karyawan', compact('karyawan'));

    $userId = session('karyawan_id');
    $today = now()->toDateString();

    $ongoing = EventModel::where('nik', Karyawan::find($userId)->nik)
        ->whereDate('tgl_awal', '<=', $today)
        ->whereDate('tgl_akhir', '>=', $today)
        ->get();

    $upcoming = EventModel::where('nik', Karyawan::find($userId)->nik)
        ->whereDate('tgl_awal', '>', $today)
        ->get();

    return view('dashboard.interfaceKaryawan', compact('ongoing', 'upcoming'));

}

}
