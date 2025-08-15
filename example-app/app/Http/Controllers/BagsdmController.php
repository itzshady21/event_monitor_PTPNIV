<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pelatihan;
use App\Models\EventModel;
use App\Models\Karyawan; 

class BagsdmController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');

        // Hitungan distinct (untuk card count)
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

        // Data tabel (paginasi) — nama variabel sesuai yang dipakai view
        $ongoingEventData = EventModel::where('tgl_awal', '<=', $today)
            ->where('tgl_akhir', '>=', $today)
            ->paginate(20, ['*'], 'ongoing_page');

        $upcomingEventData = EventModel::where('tgl_awal', '>', $today)
            ->paginate(20, ['*'], 'upcoming_page');

        $pastEventData = EventModel::where('tgl_akhir', '<', $today)
            ->paginate(20, ['*'], 'past_page');

        // Grafik bulanan
        $monthly = EventModel::selectRaw("DATE_FORMAT(tgl_awal, '%Y-%m') as bulan, COUNT(*) as jumlah")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        $monthlyLabels = $monthly->pluck('bulan');
        $monthlyCounts = $monthly->pluck('jumlah');

        // Grafik tahunan
        $yearly = EventModel::selectRaw("YEAR(tgl_awal) as tahun, COUNT(*) as jumlah")
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();
        $yearlyLabels = $yearly->pluck('tahun');
        $yearlyCounts = $yearly->pluck('jumlah');

        // Pie chart per bagian
        $bagianTotal = EventModel::select('bagian', EventModel::raw('COUNT(*) as jumlah'))
            ->groupBy('bagian')
            ->get();
        $bagianLabels = $bagianTotal->pluck('bagian');
        $bagianCounts = $bagianTotal->pluck('jumlah');

        return view('bagsdm.dashboard', [
            // Paginasi/table
            'ongoingEvents'  => $ongoingEventData,
            'upcomingEvents' => $upcomingEventData,
            'pastEvents'     => $pastEventData,

            // Count untuk cards (pakai distinct results)
            'ongoingCount'   => $ongoingEvents->count(),
            'upcomingCount'  => $upcomingEvents->count(),
            'pastCount'      => $pastEvents->count(),

            // Grafik
            'monthlyLabels'  => $monthlyLabels,
            'monthlyCounts'  => $monthlyCounts,
            'yearlyLabels'   => $yearlyLabels,
            'yearlyCounts'   => $yearlyCounts,
            'bagianLabels'   => $bagianLabels,
            'bagianCounts'   => $bagianCounts,
        ]);
    }
    public function formDataPeserta(Request $request)
{
    $query = EventModel::query();

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nik', 'like', "%{$search}%")
              ->orWhere('nama', 'like', "%{$search}%")
              ->orWhere('judul_pelatihan', 'like', "%{$search}%")
              ->orWhere('penyelenggara', 'like', "%{$search}%");
        });
    }

    $data_event = $query->paginate(20);

    return view('bagsdm.formDataPeserta', compact('data_event'));
}
public function formDataKaryawan(Request $request)
{
    $search = $request->input('search');

    $karyawans = Karyawan::when($search, function ($query) use ($search) {
        $query->where('nik', 'like', "%{$search}%")
              ->orWhere('nama', 'like', "%{$search}%");
    })
    ->orderByRaw('CAST(nik AS UNSIGNED) ASC')
    ->paginate(10);

    return view('bagsdm.formDataKaryawan', compact('karyawans'));
}
public function showPelatihan(Request $request)
{
     $query = Pelatihan::query();

    // Pencarian berdasarkan kata kunci
    if ($request->filled('search')) {
        $keyword = $request->search;
        $query->where(function($q) use ($keyword) {
            $q->where('judul_pelatihan', 'like', "%{$keyword}%")
              ->orWhere('jenis_pelatihan', 'like', "%{$keyword}%")
              ->orWhere('metode_pelatihan', 'like', "%{$keyword}%")
              ->orWhere('lokasi_pelatihan', 'like', "%{$keyword}%")
              ->orWhere('penyelenggara', 'like', "%{$keyword}%");
        });
    }

    // Filter berdasarkan tanggal
    if ($request->filled('tanggal')) {
        $query->whereDate('tgl_awal', '<=', $request->tanggal)
              ->whereDate('tgl_akhir', '>=', $request->tanggal);
    }

    $pelatihan = $query->orderBy('tgl_awal', 'asc')->paginate(20);

    return view('bagsdm.formPelatihan', compact('pelatihan'));
}

}
