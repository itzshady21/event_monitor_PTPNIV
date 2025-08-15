<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisKelaminToTblKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_karyawan', function (Blueprint $table) {
            $table->string('jenis_kelamin')->after('nama'); // Menambahkan kolom 'jenis_kelamin' setelah kolom 'nama'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_karyawan', function (Blueprint $table) {
            $table->dropColumn('jenis_kelamin'); // Menghapus kolom 'jenis_kelamin' jika migration dibatalkan
        });
    }
}
