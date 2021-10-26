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
            $table->timestamp('date'); 
            $table->string('road_location');
            $table->string('house_location')->nullable();
            $table->string('municipality');
            $table->integer('province_id');
            $table->string('landcover');
            $table->string('landmark')->nullable();
            $table->string('landslidetype')->nullable();
            $table->string('landslidereccuring');
            $table->float('lewidth')->nullable();
            $table->float('lelength')->nullable();
            $table->float('ledepth')->nullable();
            $table->integer('idkilled')->default(0);
            $table->integer('idinjured')->default(0);
            $table->integer('idmissing')->default(0);
            $table->float('idaffectedcrops')->default(0);
            $table->integer('idaffectedinfra')->default(0);
            $table->string('cause');
            $table->string('typhoonname');
            $table->string('heavyrainfall');
            $table->string('reportedby')->nullable();
            $table->string('reporterpos')->nullable();
            $table->longtext('incident_images');
            $table->float('pastrainvalue')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::drop('tbl_landslides');
    }
}
