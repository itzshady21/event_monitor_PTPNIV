<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBagianTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_bagian', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bagian');
            $table->string('kepala_bagian');
            $table->string('wakep_bagian');
            $table->date('Tgl_bagian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_bagian');
    }
}
