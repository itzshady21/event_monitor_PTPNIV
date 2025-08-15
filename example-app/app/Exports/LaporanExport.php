<?php

namespace App\Exports;

use App\Models\EventModel;
use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class LaporanExport implements FromCollection, WithHeadings
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
     * Mengambil koleksi data event berdasarkan filter.
     */
    public function collection()
    {
        $query = EventModel::query();

        if ($this->bulan && $this->tahun) {
            $query->whereMonth('tgl_awal', $this->bulan)
                  ->whereYear('tgl_awal', $this->tahun);
        } elseif ($this->tahun) {
            $query->whereYear('tgl_awal', $this->tahun);
        }

        return $query->orderBy('tgl_awal', 'asc')->get([
            'nik',
            'nama',
            'jabatan',
            'bagian',
            'unit_usaha',
            'tgl_awal',
            'tgl_akhir',
            'judul_pelatihan',
            'jenis_pelatihan',
            'lokasi_pelatihan',
            'metode_pelatihan',
            'penyelenggara',
            'biaya'

        ]);
    }

    /**
     * Menambahkan header kolom pada Excel.
     */
    public function headings(): array
    {
        return [
            'NIK',
            'Nama',
            'Jabatan',
            'Bagian',
            'Unit Usaha',
            'Tanggal Awal Pelatihan',
            'Tanggal Akhir Pelatihan',
            'Judul Pelatihan',
            'Jenis Pelatihan',
            'Lokasi Pelatihan',
            'Metode Pelatihan',
            'Penyelenggara'
        ];
    }
}
