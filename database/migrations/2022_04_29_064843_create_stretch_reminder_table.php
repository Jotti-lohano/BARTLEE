<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStretchReminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stretch_reminder', function (Blueprint $table) {
            $table->id();
            $table->string('wakeup_time');
            $table->string('sleepingHour');
            $table->string('interval');
            $table->string('reminderTime');
            $table->string('WithAlaram');
            $table->string('user_id');
            $table->string('status')->default('0');
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
        Schema::dropIfExists('stretch_reminder');
    }
}
