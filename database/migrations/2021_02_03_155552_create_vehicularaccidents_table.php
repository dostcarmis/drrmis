<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicularaccidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_vehicularaccidents', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date'); 
            $table->integer('no_of_vehicles_involved')->default(0);
            $table->integer('no_of_vehicles_damaged')->default(0);
            $table->integer('no_of_drivers_killed')->default(0);
            $table->integer('no_of_drivers_injured')->default(0);
            $table->integer('no_of_passengers_killed')->default(0);
            $table->integer('no_of_passengers_injured')->default(0);
            $table->string('road_location');
            $table->string('municipality');
            $table->integer('province_id');
            $table->text('description');
            $table->string('reportedby')->nullable();
            $table->string('reporterpos')->nullable();
            $table->longtext('incident_images');
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
        Schema::drop('tbl_vehicularaccidents');
    }
}
