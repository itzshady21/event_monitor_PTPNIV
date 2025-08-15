<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSertifikatToTblEventTable extends Migration
{
    public function up()
    {
        Schema::table('tbl_event', function (Blueprint $table) {
            $table->string('sertifikat')->nullable()->after('biaya');
        });
    }

    public function down()
    {
        Schema::table('tbl_event', function (Blueprint $table) {
            $table->dropColumn('sertifikat');
        });
    }
}

