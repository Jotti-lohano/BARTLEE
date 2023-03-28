<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameJoggingReminderColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jogging_reminder', function (Blueprint $table) {
            $table->renameColumn('remindWithAlarm', 'reminder_with_alarm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jogging_reminder', function (Blueprint $table) {
            $table->renameColumn('remindWithAlarm', 'reminder_with_alarm');
        });
    }
}
