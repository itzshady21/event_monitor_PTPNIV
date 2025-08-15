<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
use App\Models\Karyawan;
use App\Models\Pelatihan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class JadwalPelatihanController extends Controller
{
    public function index($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $pelatihans = EventModel::where('nik', $karyawan->nik)->get();

        $pelatihans = Pelatihan::paginate(10);

        return view('dashboard.pelatihan', compact('pelatihans', 'karyawan'));
    }

    public function sertifikat()
    {
        // Ambil ID dari session yang benar
        $karyawanId = session('karyawan_id');

        if (!$karyawanId) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data karyawan
        $karyawan = Karyawan::find($karyawanId);
        if (!$karyawan) {
            return redirect('/login')->with('error', 'Data karyawan tidak ditemukan.');
        }

        // Ambil pelatihan yang sudah berakhir dan memiliki sertifikat
        $pelatihanBerakhir = EventModel::where('nik', $karyawan->nik)
            ->whereDate('tgl_akhir', '<', now())
            ->whereNotNull('sertifikat')
            ->paginate(10);

        return view('dashboard.sertifikat', compact('pelatihanBerakhir'));
    }

    public function downloadSertifikat($id)
    {
        $event = EventModel::findOrFail($id);

        if (!$event->sertifikat || !Storage::disk('public')->exists($event->sertifikat)) {
            return redirect()->back()->with('error', 'Sertifikat tidak ditemukan.');
        }

        return response()->download(storage_path('app/public/' . $event->sertifikat));
    }
    public function riwayatPelatihan()
    {
        // Pastikan sudah login
        if (!session()->has('karyawan_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil karyawan berdasarkan ID di session
        $karyawan = Karyawan::find(session('karyawan_id'));

        if (!$karyawan) {
            return redirect()->route('login')->with('error', 'Data karyawan tidak ditemukan.');
        }

        // Ambil hanya pelatihan yang diikuti karyawan ini
        $pelatihans = EventModel::where('nik', $karyawan->nik)
            ->orderBy('tgl_awal', 'desc')
            ->paginate(10);

        return view('dashboard.pelatihan', compact('pelatihans', 'karyawan'));
    }

}
