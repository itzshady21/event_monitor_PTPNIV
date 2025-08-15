<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'tbl_pelatihan';

    protected $fillable = [
        'judul_pelatihan',
        'penyelenggara',
        'lokasi_pelatihan',
        'tgl_awal',
        'tgl_akhir',
        'metode_pelatihan',
        'jenis_pelatihan',
        'biaya',
    ];

    
}
