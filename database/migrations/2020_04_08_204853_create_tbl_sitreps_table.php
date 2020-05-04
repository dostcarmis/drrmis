<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSitrepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sitreps', function (Blueprint $table) {
            $table->increments('id');
            $table->text('uploadedby');
            $table->string('risk_type');
            $table->string('typhoon_name')->nullable();
            $table->text('original_name');
            $table->text('sitrep_level');
            $table->text('filetype');
            $table->text('filename');
            $table->string('file');
            $table->text('fileurl');
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
        //
    }
}
