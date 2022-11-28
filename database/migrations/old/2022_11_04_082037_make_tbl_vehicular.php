<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeTblVehicular extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_vehicular', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uploader_id');
            $table->integer('editor_id');
            $table->date('date');
            $table->string('incident_images');
            $table->string('description');
            $table->string('reportedby');
            $table->integer('casualties');
            $table->integer('province_id');
            $table->integer('municipality_id');
            $table->float('damages');
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_fires');
    }
}
