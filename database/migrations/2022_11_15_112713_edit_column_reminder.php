<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnReminder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reminder_time_schedule', function (Blueprint $table) {
            // $table->renameColumn('time_schedule', 'reminder_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reminder_time_schedule', function (Blueprint $table) {
            $table->renameColumn('time_schedule	', 'reminder_time');
        });
    }
}
