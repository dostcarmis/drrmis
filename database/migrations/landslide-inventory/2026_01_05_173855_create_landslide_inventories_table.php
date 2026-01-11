<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandslideInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landslide_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('location')->nullable();
            $table->json('details')->nullable();
            $table->json('analysis')->nullable();
            $table->json('remarks')->nullable();
            $table->unsignedInteger('created_by_id')->nullable();
            $table->foreign('created_by_id')
                ->references('id')
                ->on('users');
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
        Schema::dropIfExists('landslide_inventories');
    }
}
