<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWaterlevelnotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_notificationwaterlevel', function (Blueprint $table) {
            $table->increments('id');          
            $table->date('date');
            $table->integer('nc_id');
            $table->integer('alertstatus');
            $table->integer('municipality_id');
            $table->integer('province_id');
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
        Schema::drop('tbl_notificationwaterlevel');
    }
}
