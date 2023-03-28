<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_artists', function (Blueprint $table) {
            $table->id();
            $table->integer('user_profile_id')->nullable();
            $table->string('about_yourself')->nullable();
            $table->string('years_of_experience')->nullable();
            $table->string('company_name')->nullable();
            $table->string('profile_picture')->nullable();
            $table->integer('artist_profession')->nullable();
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
        Schema::dropIfExists('user_artists');
    }
}
