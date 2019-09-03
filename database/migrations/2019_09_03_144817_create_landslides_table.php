<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandslidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_landslides', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('road_location');
            $table->string('house_location');
            $table->string('municipality');
            $table->integer('land_cover');
            $table->string('landmark');
            $table->string('landslidetype');
            $table->integer('lewidth');
            $table->integer('lelength');
            $table->integer('ledepth');
            $table->integer('idkilled');
            $table->integer('idinjured');
            $table->integer('idaffectedcrops');
            $table->integer('idaffectedinfra');
            $table->string('cause');
            $table->string('typhoonname');
            $table->string('heavyrainfall');
            $table->string('reportedby');
            $table->string('reporterpos');
            $table->time('reporttime');
            $table->integer('incident_images');
            $table->integer('province_id');
            $table->integer('pastrainvalue');
            $table->string('latitude');
            $table->string('longitude');
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
