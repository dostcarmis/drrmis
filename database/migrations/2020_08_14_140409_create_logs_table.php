<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('userid')->nullable();
            $table->string('request')->nullable();
            $table->string('method')->nullable();
            $table->string('host');
            $table->text('useragent');
            $table->string('userfullname')->nullable();
            $table->string('usermunicipality')->nullable();
            $table->string('userprovince')->nullable();
            $table->text('remarks');
            $table->timestamp('logged_at');
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
