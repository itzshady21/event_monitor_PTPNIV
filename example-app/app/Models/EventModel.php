<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_event';

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    protected $fillable = [
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
        'biaya',
        'sertifikat'
    ];
}
