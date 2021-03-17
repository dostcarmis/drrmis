<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSentMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sent_messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->uuid('id')->primary();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('group_id');
            $table->foreign('group_id')->references('id')->on('tbl_groups');
            $table->binary('recipients');
            $table->text('message');
            $table->binary('status');
            $table->timestamps('created_at');
        });

        DB::statement("ALTER TABLE tbl_sent_messages CHANGE `recipients` `recipients` MEDIUMBLOB");
        DB::statement("ALTER TABLE tbl_sent_messages CHANGE `status` `status` MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_sent_messages');
    }
}
