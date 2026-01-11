<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandslideInventoryCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landslide_inventory_candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('landslide_inventory_id')->nullable();
            $table->foreign('landslide_inventory_id')
                ->references('id')
                ->on('landslide_inventories');
            $table->unsignedInteger('candidate_id');
            $table->date('date');
            $table->unsignedInteger('province_id')->nullable();
            $table->foreign('province_id')
                ->references('id')
                ->on('tbl_provinces');
            $table->unsignedInteger('municipality_id')->nullable();
            $table->foreign('municipality_id')
                ->references('id')
                ->on('tbl_municipality');
            $table->string('location')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('area_m2', 12, 2);
            $table->unsignedInteger('validator_id');
            $table->foreign('validator_id')
                ->references('id')
                ->on('users');
            $table->unsignedInteger('validation_id')->default(1);
            $table->foreign('validation_id')
                ->references('id')
                ->on('landslide_inventory_validations');
            $table->json('incident_images')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landslide_inventory_candidates');
    }
}
