<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncident extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_incidents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('incident_type');
            $table->date('date');
            $table->string('location');
            $table->string('incident_images');
            $table->integer('province_id');
            $table->integer('pastrainvalue');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('description');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->string('author');
            $table->string('user_municipality');
            $table->string('report_status');
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
        Schema::drop('tbl_incidents');
    }
}
