<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReminderLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminder_log', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reminderable_id')->nullable()->unsigned();
            $table->string('reminderable_type')->nullable();
            $table->string('user_id');
            $table->string('reminder_date');
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
        Schema::dropIfExists('reminder_log');
    }
}
