<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_type')->default('user')->comment('patient,attendee');
            $table->string('device_token')->nullable();
            $table->string('device_type')->nullable();
            $table->string('avatar')->default('no-image.png');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('dob')->nullable();
            $table->string('mobile')->nullable();
            $table->string('gender')->nullable();
            $table->string('location')->nullable();
            $table->boolean('status')->default(false)->comment('1 is active');
            $table->rememberToken();
            $table->timestamps();
        });

        $user = new User;
        $user->device_token = '';
        $user->first_name = "imeds";
        $user->last_name = "application";
        $user->username = "imeds application";
        $user->email = "imeds@email.com";
        $user->email_verified_at = now();
        $user->password = bcrypt("password");
        $user->dob = Carbon::now()->subDays(3000)->format('Y-m-d');
        $user->mobile = "442045771138";
        $user->gender = "male";
        $user->status = 1;
        $user->remember_token = Str::random(10);
        $user->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
