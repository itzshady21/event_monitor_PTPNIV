<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetodeJenisToTblPelatihanTable extends Migration
{
    public function up()
    {
        Schema::table('tbl_pelatihan', function (Blueprint $table) {
            $table->string('metode_pelatihan')->after('judul_pelatihan')->nullable();
            $table->string('jenis_pelatihan')->after('metode_pelatihan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('tbl_pelatihan', function (Blueprint $table) {
            $table->dropColumn('metode_pelatihan');
            $table->dropColumn('jenis_pelatihan');
        });
    }
}

