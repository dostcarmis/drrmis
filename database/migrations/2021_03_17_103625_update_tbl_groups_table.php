<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_groups', function (Blueprint $table) {
            $table->renameColumn('grp_id', 'id');
        });

        DB::statement('ALTER TABLE `tbl_groups` CHANGE `id` `id` CHAR(36);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_groups', function (Blueprint $table) {
            $table->renameColumn('id', 'grp_id');
        });

        DB::statement('ALTER TABLE `tbl_groups` CHANGE `grp_id` `grp_id` INTEGER(11);');
    }
}
