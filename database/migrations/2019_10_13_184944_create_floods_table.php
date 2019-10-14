<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFloodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_floods', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date'); 
            $table->string('road_location');
            $table->string('municipality');
            $table->integer('province_id');
            $table->string('river_system');
            $table->string('flood_type')->nullable();
            $table->string('flood_reccuring');
            $table->float('flood_waterlvl')->nullable();
            $table->string('measuredat');
            $table->integer('flood_killed')->default(0);
            $table->integer('flood_injured')->dafault(0);
            $table->integer('flood_missing')->dafault(0);
            $table->float('flood_affectedcrops')->dafault(0);
            $table->integer('flood_affectedinfra')->dafault(0);
            $table->string('cause');
            $table->string('typhoon_name');
            $table->string('heavy_rainfall');
            $table->string('reported_by')->nullable();
            $table->string('reporter_pos')->nullable();
            $table->longtext('incident_images');
            $table->float('past_rainvalue')->nullable();
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
        Schema::drop('tbl_floods');
    }
}
