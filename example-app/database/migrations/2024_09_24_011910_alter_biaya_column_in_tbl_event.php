<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE tbl_event MODIFY biaya INT NULL');
    }
    
    public function down()
    {
        DB::statement('ALTER TABLE tbl_event MODIFY biaya DECIMAL(10, 2) NULL');
    }
    
};
