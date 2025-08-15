<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
use App\Models\Karyawan; 
use Maatwebsite\Excel\Facades\Excel; 
use App\Models\Pelatihan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventController extends Controller
{
    public function formEvent()
    {
        $karyawans = Karyawan::all();
        $today = now()->toDateString();
        $pelatihans = Pelatihan::all();

        return view('formEvent', compact('karyawans', 'pelatihans'));
    }

    public function storeEvent(Request $request)
    {
        

        $niks = $request->input('peserta');

        foreach ($niks as $nik) {
            $karyawan = Karyawan::where('nik', $nik)->first();

            if (!$karyawan) continue;

            $event = new EventModel;
            $event->tgl_awal         = $request->tgl_awal;
            $event->tgl_akhir        = $request->tgl_akhir;
            $event->judul_pelatihan  = $request->judul_pelatihan;
            $event->jenis_pelatihan  = $request->jenis_pelatihan;
            $event->lokasi_pelatihan = $request->lokasi_pelatihan ?? '-';
            $event->metode_pelatihan = $request->metode_pelatihan;
            $event->penyelenggara    = $request->penyelenggara;
            $event->biaya            = $request->biaya;

            $event->nik         = $karyawan->nik;
            $event->nama        = $karyawan->nama;
            $event->jabatan     = $karyawan->jabatan;
            $event->bagian      = $karyawan->bagian;
            $event->unit_usaha  = $karyawan->unit_usaha;

            $event->save();
        }

        return redirect()->route('formLihatData')->with('success', 'Data berhasil disimpan.');
    }

    public function formLihatData(Request $request)
    {
        $query = EventModel::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nik', 'LIKE', "%{$search}%")
                  ->orWhere('nama', 'LIKE', "%{$search}%")
                  ->orWhere('jabatan', 'LIKE', "%{$search}%")
                  ->orWhere('bagian', 'LIKE', "%{$search}%")
                  ->orWhere('judul_pelatihan', 'LIKE', "%{$search}%")
                  ->orWhere('tgl_awal', 'LIKE', "%{$search}%")
                  ->orWhere('tgl_akhir', 'LIKE', "%{$search}%")
                  ->orWhere('penyelenggara', 'LIKE', "%{$search}%");
        }

        $data['judul'] = "Lihat Data";
        $data['data_event'] = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('formLihatData', $data);
    }

    public function editEvent($id)
    {
        $event = EventModel::findOrFail($id);
        $karyawans = Karyawan::all();

        // Since one event per peserta, nik disimpan satu saja
        return view('formLihatData', [
            'data' => $event,
            'karyawans' => $karyawans,
            'selectedNik' => $event->nik,
        ]);
    }

    public function updateEvent(Request $request, $id)
{
    $event = EventModel::findOrFail($id);
    $event->update([
        'judul_pelatihan' => $request->judul_pelatihan,
        'penyelenggara' => $request->penyelenggara,
        'tgl_awal' => $request->tgl_awal,
        'tgl_akhir' => $request->tgl_akhir,
        'jenis_pelatihan' => $request->jenis_pelatihan,
        'lokasi_pelatihan' => $request->lokasi_pelatihan,
        'metode_pelatihan' => $request->metode_pelatihan,
        'biaya' => $request->biaya,
    ]);

    // Jika request via AJAX
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui.'
        ]);
    }

    // fallback biasa
    return redirect()->route('formLihatData')->with('success', 'Data berhasil diperbarui');
}


    public function deleteEvent($id)
    {
        $event = EventModel::find($id);
        if ($event) {
            $event->delete();
        }
        return redirect()->route('formLihatData')->with('success', 'Data berhasil dihapus.');
    }

   public function dashboard()
{
    $today = date('Y-m-d');

    // Event per status
    $ongoingEvents = EventModel::select('judul_pelatihan', 'tgl_awal', 'tgl_akhir')
        ->where('tgl_awal', '<=', $today)
        ->where('tgl_akhir', '>=', $today)
        ->distinct('judul_pelatihan')
        ->get();

    $upcomingEvents = EventModel::select('judul_pelatihan', 'tgl_awal', 'tgl_akhir')
        ->where('tgl_awal', '>', $today)
        ->distinct('judul_pelatihan')
        ->get();

    $pastEvents = EventModel::select('judul_pelatihan', 'tgl_awal', 'tgl_akhir')
        ->where('tgl_akhir', '<', $today)
        ->distinct('judul_pelatihan')
        ->get();

    // Ambil data tabel
    $ongoingEventData = EventModel::where('tgl_awal', '<=', $today)
                                  ->where('tgl_akhir', '>=', $today)
                                  ->paginate(20, ['*'], 'ongoing_page');

    $upcomingEventData = EventModel::where('tgl_awal', '>', $today)
                                   ->paginate(20, ['*'], 'upcoming_page');

    $pastEventData = EventModel::where('tgl_akhir', '<', $today)
                               ->paginate(20, ['*'], 'past_page');

    // --- Grafik batang: jumlah peserta per bulan ---
    $monthly = EventModel::selectRaw("DATE_FORMAT(tgl_awal, '%Y-%m') as bulan, COUNT(*) as jumlah")
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();

    $monthlyLabels = $monthly->pluck('bulan');
    $monthlyCounts = $monthly->pluck('jumlah');

    // --- Grafik batang per tahun ---
    $yearly = EventModel::selectRaw("YEAR(tgl_awal) as tahun, COUNT(*) as jumlah")
                ->groupBy('tahun')
                ->orderBy('tahun')
                ->get();

    $yearlyLabels = $yearly->pluck('tahun');
    $yearlyCounts = $yearly->pluck('jumlah');

    // --- Pie chart total seluruh bagian ---
    $bagianTotal = EventModel::select('bagian', EventModel::raw('COUNT(*) as jumlah'))
        ->groupBy('bagian')
        ->get();

    $bagianLabels = $bagianTotal->pluck('bagian');
    $bagianCounts = $bagianTotal->pluck('jumlah');

    return view('dashboard', [
        'ongoingEvents' => $ongoingEventData,
        'upcomingEvents' => $upcomingEventData,
        'pastEvents' => $pastEventData,
        'ongoingCount' => $ongoingEvents->count(),
        'upcomingCount' => $upcomingEvents->count(),
        'pastCount' => $pastEvents->count(),

        'monthlyLabels' => $monthlyLabels,
        'monthlyCounts' => $monthlyCounts,
        'yearlyLabels' => $yearlyLabels,
        'yearlyCounts' => $yearlyCounts,
        'bagianLabels' => $bagianLabels,
        'bagianCounts' => $bagianCounts,

    ]);
}
    public function formSertifikat(Request $request)
    {
        $today = now()->toDateString();
        $query = EventModel::where('tgl_akhir', '<', $today);
        $events = $query->orderBy('tgl_akhir', 'desc')->paginate(20);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul_pelatihan', 'like', "%$search%")
                ->orWhere('tgl_awal', 'like', "%$search%")
                ->orWhere('tgl_akhir', 'like', "%$search%")
                ->orWhere('nama', 'like', "%$search%")
                ->orWhere('nik', 'like', "%$search%")
                ->orWhere('lokasi_pelatihan', 'like', "%$search%")
                ->orWhere('metode_pelatihan', 'like', "%$search%");
            });
        }

    $events = $query->orderBy('tgl_akhir', 'desc')->paginate(20);
    return view('formSertifikat', compact('events'));
}


public function uploadSertifikat(Request $request, $id)
{
    $request->validate([
        'sertifikat' => 'required|file|mimes:pdf|max:51200', // max 50MB
    ]);

    $event = EventModel::findOrFail($id);

    if ($request->hasFile('sertifikat')) {
        $file = $request->file('sertifikat');
        $filename = 'sertifikat_' . $event->nik . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('sertifikat', $filename, 'public');
        $event->sertifikat = $path;
        $event->save();
    }

    return redirect()->back()->with('success', 'Sertifikat berhasil diunggah.');
}

public function editSertifikat(Request $request, $id)
{
    $request->validate([
        'sertifikat' => 'required|file|mimes:pdf|max:51200', // max 50MB
    ]);

    $event = EventModel::findOrFail($id);

    if ($request->hasFile('sertifikat')) {
        $file = $request->file('sertifikat');
        $filename = 'sertifikat_' . $event->nik . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('sertifikat', $filename, 'public');
        $event->sertifikat = $path;
        $event->save();
    }

    return redirect()->back()->with('success', 'Sertifikat berhasil diperbarui.');
}

}
