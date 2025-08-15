<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
use App\Models\Pelatihan;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PelatihanController extends Controller
{

   public function index(Request $request)
    {
        $search = $request->search;
        $pelatihan = Pelatihan::when($search, function($query) use ($search) {
            return $query->where('judul_pelatihan', 'like', "%{$search}%")
                        ->orWhere('lokasi_pelatihan', 'like', "%{$search}%")
                        ->orWhere('penyelenggara', 'like', "%{$search}%");
        })->paginate(10);

        if ($request->ajax()) {
            return view('formPelatihan', compact('pelatihan'))->render();
        }

        return view('formPelatihan', compact('pelatihan'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'judul_pelatihan' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'lokasi_pelatihan' => 'nullable|string|max:255',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'metode_pelatihan' => 'required|string|max:100',
            'jenis_pelatihan' => 'required|string|max:100',
            'biaya' => 'required|numeric|min:0',
        ]);
        
        if ($request->metode_pelatihan === 'Online') {
             $request->merge(['lokasi_pelatihan' => '-']);
            }

        Pelatihan::create($request->all());

        return redirect()->route('formPelatihan')->with('success', 'Data pelatihan berhasil disimpan');
    }

    public function edit($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        return response()->json($pelatihan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_pelatihan' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'lokasi_pelatihan' => 'nullable|string|max:255',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'metode_pelatihan' => 'required|string|max:100',
            'jenis_pelatihan' => 'required|string|max:100',
            'biaya' => 'required|numeric|min:0',
        ]);

        if ($request->metode_pelatihan === 'Online') {
            $request->merge(['lokasi_pelatihan' => '-']);
         }

        $pelatihan = Pelatihan::findOrFail($id);
        $pelatihan->update($request->all());

        return redirect()->route('formPelatihan')->with('success', 'Data pelatihan berhasil diupdate');
    }

    public function destroy($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        $pelatihan->delete();

        return redirect()->route('formPelatihan')->with('success', 'Data pelatihan berhasil dihapus');
    }

    // API method untuk detail pelatihan, dipanggil AJAX
   public function getPelatihanDetail($id)
{
    $pelatihan = Pelatihan::findOrFail($id);
    return response()->json($pelatihan);
}

// app/Http/Controllers/PelatihanController.php

public function getPelatihanById($id)
{
    $pelatihan = Pelatihan::find($id);

    if (!$pelatihan) {
        return response()->json(['error' => 'Pelatihan tidak ditemukan'], 404);
    }

    // Kirim data yang diperlukan
    return response()->json([
        'penyelenggara' => $pelatihan->penyelenggara,
        'lokasi_pelatihan' => $pelatihan->lokasi_pelatihan,
        'tgl_awal' => $pelatihan->tgl_awal,
        'tgl_akhir' => $pelatihan->tgl_akhir,
        'metode_pelatihan' => $pelatihan->metode_pelatihan,
        'jenis_pelatihan' => $pelatihan->jenis_pelatihan,
        'biaya' => $pelatihan->biaya,
    ]);
}

    public function showRegisterForm()
    {
        $pelatihan = Pelatihan::paginate(10);
        return view('dashboard.registerPelatihan', compact('pelatihan'));
    }

    public function registerToPelatihan(Request $request, $id)
    {
        // Ambil pelatihan
        $pelatihan = Pelatihan::findOrFail($id);

        // Ambil user login (misal session user ID disimpan)
        $userId = session('karyawan_id'); // atau gunakan Auth jika pakai Laravel Auth
        $karyawan = Karyawan::findOrFail($userId);

        // Simpan ke tbl_event
        EventModel::create([
            'nik'              => $karyawan->nik,
            'nama'             => $karyawan->nama,
            'jabatan'          => $karyawan->jabatan,
            'bagian'           => $karyawan->bagian,
            'unit_usaha'       => $karyawan->unit_usaha,
            'judul_pelatihan'  => $pelatihan->judul_pelatihan,
            'tgl_awal'         => $pelatihan->tgl_awal,
            'tgl_akhir'        => $pelatihan->tgl_akhir,
            'metode_pelatihan' => $pelatihan->metode_pelatihan,
            'lokasi_pelatihan' => $pelatihan->lokasi_pelatihan,
            'jenis_pelatihan'  => $pelatihan->jenis_pelatihan,
            'penyelenggara'    => $pelatihan->penyelenggara,
            'biaya'            => $pelatihan->biaya,
        ]);

        return redirect()->back()->with('success', 'Berhasil mendaftar pelatihan!');
    }


}
