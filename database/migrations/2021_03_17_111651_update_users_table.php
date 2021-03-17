<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `users` CHANGE `group` `group` CHAR(36);');
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('group')->references('id')->on('tbl_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_group_foreign');
        });
        DB::statement('ALTER TABLE `users` CHANGE `group` `group` INTEGER(11);');
    }
}
