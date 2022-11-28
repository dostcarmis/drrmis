<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAffectedareas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_affectedareas_flood', function (Blueprint $table) {
            $table->increments('id');          
            $table->integer('threshold_id');
            $table->string('level1Areas');
            $table->string('level2Areas');
            $table->string('criticalAreas');
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
        Schema::drop('tbl_affectedareas_flood');
    }
}
