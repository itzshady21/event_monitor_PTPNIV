<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBagianFromTblPelatihanTable extends Migration
{
    public function up()
    {
        Schema::table('tbl_pelatihan', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_pelatihan', 'bagian')) {
                $table->dropColumn('bagian');
            }
        });
    }

    public function down()
    {
        Schema::table('tbl_pelatihan', function (Blueprint $table) {
            $table->string('bagian')->nullable(); // Kembalikan kolom jika rollback
        });
    }
}

