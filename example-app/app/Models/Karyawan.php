<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'tbl_karyawan';


    protected $fillable = [
        'nik', 'nama', 'jenis_kelamin', 'tempat', 'tanggal_lahir', 'agama', 'pendidikan', 'alamat', 'jabatan', 'bagian', 'bod', 'unit_usaha', 'status_perkawinan', 'no_telp', 'email', 'password', 'foto'];

    public function events()
    {
        return $this->hasMany(Event::class, 'karyawan_id');
    }


}
