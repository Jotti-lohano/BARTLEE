<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSnoozeInReminderLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reminder_log', function (Blueprint $table) {
            $table->boolean('going')->default(0);
            $table->boolean('completed')->default(0);
            $table->boolean('later')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reminder_log', function (Blueprint $table) {
            //
        });
    }
}
