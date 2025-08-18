<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Bagian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function create()
    {
        $bagians = Bagian::orderBy('nama_bagian', 'asc')->get(); 
        return view('formKaryawan', compact('bagians')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:tbl_karyawan',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tempat' => 'required',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required',
            'pendidikan' => 'required',
            'alamat' => 'required',
            'jabatan' => 'required',
            'bagian' => 'required',
            'bod' => 'required',
            'unit_usaha' => 'required',
            'status_perkawinan' => 'required',
            'no_telp' => 'nullable',
            'email' => 'required|email|unique:tbl_karyawan',
            'password' => 'required',
            'foto' => 'nullable|image|max:5120'
        ]);

        
        $karyawan = new Karyawan();
        $karyawan->nik = $request->nik;
        $karyawan->nama = $request->nama;
        $karyawan->jenis_kelamin = $request->jenis_kelamin ;
        $karyawan->tempat = $request->tempat;
        $karyawan->tanggal_lahir = $request->tanggal_lahir;
        $karyawan->agama = $request->agama;
        $karyawan->pendidikan = $request->pendidikan;
        $karyawan->alamat = $request->alamat;
        $karyawan->jabatan = $request->jabatan;
        $karyawan->bagian = $request->bagian;
        $karyawan->bod = $request->bod;
        $karyawan->unit_usaha = $request->unit_usaha;
        $karyawan->status_perkawinan = $request->status_perkawinan;
        $karyawan->no_telp = $request->no_telp;
        $karyawan->email = $request->email;
        $karyawan->password = $request->password; // jika belum di-hash

            if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto', 'public');
            $karyawan->foto = basename($foto);
        }
        
        $karyawan->save();

        return redirect()->route('listKaryawan')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $karyawans = Karyawan::when($search, function ($query, $search) {
            return $query->where('nik', 'LIKE', "%{$search}%")
                         ->orWhere('nama', 'LIKE', "%{$search}%")
                         ->orWhere('jabatan', 'LIKE', "%{$search}%")
                         ->orWhere('bagian', 'LIKE', "%{$search}%")
                         ->orWhere('unit_usaha','LIKE', "%{$search}%")
                         ->orWhere('bod', 'LIKE', "%{$search}%");
        })
        ->orderBy('nik', 'asc')
        ->paginate(20); 

        $bagians = Bagian::orderBy('nama_bagian', 'asc')->get(); 

        return view('formListKaryawan', compact('karyawans', 'bagians'));
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return response()->json($karyawan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tempat' => 'required',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required',
            'pendidikan' => 'required',
            'alamat' => 'required',
            'jabatan' => 'required',
            'bagian' => 'required',
            'bod' => 'required',
            'unit_usaha' => 'required',
            'status_perkawinan' => 'required',
            'no_telp' => 'nullable',
            'email' => 'required|email',
            'password' => 'required',
            'foto' => 'nullable|image|max:5120'
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($karyawan->foto && Storage::disk('public')->exists('foto/' . $karyawan->foto)) {
                Storage::disk('public')->delete('foto/' . $karyawan->foto);
            }
            $foto = $request->file('foto')->store('foto', 'public');
            $data['foto'] = basename($foto);
        }

        $karyawan->update($data);

        return redirect()->route('listKaryawan')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        // Hapus foto saat delete data
        if ($karyawan->foto && Storage::disk('public')->exists('foto/' . $karyawan->foto)) {
            Storage::disk('public')->delete('foto/' . $karyawan->foto);
        }

        $karyawan->delete();

        return redirect()->route('listKaryawan')->with('success', 'Data Karyawan berhasil dihapus.');
    }
}
