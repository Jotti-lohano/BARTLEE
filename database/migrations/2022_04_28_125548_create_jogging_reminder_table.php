<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoggingReminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jogging_reminder', function (Blueprint $table) {
            $table->id();
            $table->string('jogging_time');
            $table->string('interval');
            $table->string('duration_type');
            $table->string('duration_number');
            $table->string('remindTime');
            $table->string('remindWithAlarm');
            $table->string('user_id');
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
        Schema::dropIfExists('jogging_reminder');
    }
}
