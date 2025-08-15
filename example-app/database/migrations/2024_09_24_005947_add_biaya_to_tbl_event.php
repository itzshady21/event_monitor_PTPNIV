<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBiayaToTblEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_event', function (Blueprint $table) {
            $table->decimal('biaya', 10, 2)->nullable()->after('penyelenggara'); // Menambahkan kolom 'biaya' setelah kolom 'penyelenggara'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_event', function (Blueprint $table) {
            $table->dropColumn('biaya'); // Menghapus kolom 'biaya' jika di-rollback
        });
    }
}
