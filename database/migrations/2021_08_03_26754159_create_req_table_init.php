<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReqTableInit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('devices', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('user_id');
            $table->text('device_token')->nullable();
            $table->string('device_type')->nullable();
            $table->string('app_version')->nullable();
            $table->integer('status')->default(0);
            $table->text('session_token')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->unique('id');
            $table->index('user_id');
            $table->primary('id');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('devices');

    }
}
