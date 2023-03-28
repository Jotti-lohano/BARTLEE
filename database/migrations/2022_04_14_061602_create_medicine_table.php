<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine', function (Blueprint $table) {
            $table->id();
            $table->string('medicine_name')->nullable();
            $table->string('medicine_type')->nullable();
            $table->string('medicine_color')->nullable();
            $table->string('potency_volume_medicine')->nullable();
            $table->string('medicine_quantity')->nullable();
            $table->string('before_afterMeal')->nullable();
            $table->string('interval')->nullable();
            $table->string('notes')->nullable();
            $table->string('medicine_picture')->default('no-image.png');
            $table->string('medicine_prescription_picture')->default('no-image.png');
            $table->integer('status')->default('1');
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
        Schema::dropIfExists('medicine');
    }
}
