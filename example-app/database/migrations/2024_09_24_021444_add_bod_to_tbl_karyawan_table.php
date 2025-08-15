<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBodToTblKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_karyawan', function (Blueprint $table) {
            $table->text('bod')->after('bagian'); // Menambahkan kolom 'bod' setelah kolom 'bagian' dengan tipe text
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
            $table->dropColumn('bod'); // Menghapus kolom 'bod' jika migration dibatalkan
        });
    }
}
