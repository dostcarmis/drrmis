<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSentMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_sent_messages', function (Blueprint $table) {
            $table->string("sms_medium")->after("message")->nullable();
            DB::statement('ALTER TABLE tbl_sent_messages CHANGE `group_id` `group_id` char(36) DEFAULT NULL;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_sent_messages', function (Blueprint $table) {
            $table->dropColumn("sms_medium");
        });
    }
}
