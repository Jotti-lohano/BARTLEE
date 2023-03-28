<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrinkingReminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drinking_reminder', function (Blueprint $table) {
            $table->id();
            $table->string('water_intake_amount');
            $table->string('wakeup_time');
            $table->string('sleeping_hour');
            $table->string('interval');
            $table->string('other_interval_minutes');
            $table->string('remind_time');
            $table->string('reminder_with_alarm');
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
        Schema::dropIfExists('drinking_reminder');
    }
}
