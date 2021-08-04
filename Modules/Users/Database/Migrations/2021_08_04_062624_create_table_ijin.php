<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIjin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ijin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('type');
            $table->integer('cuti_terpakai');
            $table->integer('jumlah_hari_potong_gaji');
            $table->integer('jumlah_hari_kerja');
            $table->string('status');
            $table->uuid('approved_by');
            $table->datetime('approved_at');
            $table->timestamps();

            
            $table->index('user_id');
            $table->index('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ijin');
    }
}
