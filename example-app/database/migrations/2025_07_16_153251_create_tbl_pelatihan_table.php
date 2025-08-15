<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPelatihanTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_pelatihan', function (Blueprint $table) {
            $table->id(); // field id (auto increment)
            $table->string('judul_pelatihan');
            $table->string('penyelenggara');
            $table->string('lokasi_pelatihan');
            $table->string('bagian');
            $table->date('tgl_awal');
            $table->date('tgl_akhir');
            $table->decimal('biaya', 15, 2); // format biaya dengan 2 angka di belakang koma
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pelatihan');
    }
}
