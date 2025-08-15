<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bagian extends Model
{
    protected $table = 'tbl_bagian'; 
    public $timestamps = false;

    protected $fillable = ['nama_bagian', 'kepala_bagian', 'wakep_bagian', 'Tgl_bagian'];
}

