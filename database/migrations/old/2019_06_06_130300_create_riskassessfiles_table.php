<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiskassessfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_riskassessfiles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('uploadedby');
            $table->text('original_name');
            $table->text('province');
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
        Schema::drop('files');
    }
}
