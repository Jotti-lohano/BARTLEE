<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameStretchReminderColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stretch_reminder', function (Blueprint $table) {
            $table->renameColumn('WithAlaram', 'reminder_with_alarm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stretch_reminder', function (Blueprint $table) {
            $table->renameColumn('WithAlaram', 'reminder_with_alarm');
        });
    }
}
