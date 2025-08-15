<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitUsahaToTblKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_karyawan', function (Blueprint $table) {
            $table->text('unit_usaha')->after('bod'); // Menambahkan kolom 'unit_usaha' setelah kolom 'bod' dengan tipe text
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
            $table->dropColumn('unit_usaha'); // Menghapus kolom 'unit_usaha' jika migration dibatalkan
        });
    }
}
