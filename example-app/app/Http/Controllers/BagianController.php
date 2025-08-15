<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bagian;
use App\Models\Karyawan;


class BagianController extends Controller
{
    // Tampilkan form dan daftar bagian
   public function index()
    {
        $bagians = Bagian::orderBy('created_at', 'desc')->get();
        $karyawans = Karyawan::orderBy('nama')->get(); // ambil data karyawan

        return view('formBagian', compact('bagians', 'karyawans'));
    }


    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_bagian' => 'required|string|max:255',
            'kepala_bagian' => 'required|string|max:255',
            'wakep_bagian' => 'required|string|max:255',
            'Tgl_bagian' => 'required|date',
        ]);

        Bagian::create($request->all());

        return redirect()->route('bagian.index')->with('success', 'Data bagian berhasil disimpan.');
    }

    // Update data yang diedit dari modal
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bagian' => 'required|string|max:255',
            'kepala_bagian' => 'required|string|max:255',
            'wakep_bagian' => 'required|string|max:255',
            'Tgl_bagian' => 'required|date',
        ]);

        $bagian = Bagian::findOrFail($id);
        $bagian->update($request->all());

        return redirect()->route('bagian.index')->with('success', 'Data bagian berhasil diperbarui.');
    }

    // Hapus data
    public function destroy($id)
    {
        $bagian = Bagian::findOrFail($id);
        $bagian->delete();

        return redirect()->route('bagian.index')->with('success', 'Data bagian berhasil dihapus.');
    }
}
