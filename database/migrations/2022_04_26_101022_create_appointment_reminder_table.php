<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentReminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_reminder', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_title');
            $table->string('doctor_name');
            $table->string('category');
            $table->string('hospital_name');
            $table->string('location');
            $table->string('room_number');
            $table->string('contact_number');
            $table->string('email');
            $table->text('notes');
            $table->string('days_to_visit');
            $table->string('visit_time');
            $table->string('status')->nullable()->default('active');
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
        Schema::dropIfExists('appointment_reminder');
    }
}
