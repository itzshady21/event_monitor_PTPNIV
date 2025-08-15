<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPendidikanToTblKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_karyawan', function (Blueprint $table) {
            $table->string('pendidikan')->after('tanggal_lahir'); // Menambahkan kolom 'pendidikan' setelah kolom 'tanggal_lahir'
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
            $table->dropColumn('pendidikan'); // Menghapus kolom 'pendidikan' jika migration dibatalkan
        });
    }
}
