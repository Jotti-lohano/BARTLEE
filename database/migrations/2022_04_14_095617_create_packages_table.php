<?php

use App\Models\Package;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->string('type');
            $table->string('duration');
            $table->text('description');
            $table->float('package_amount');
            $table->timestamps();
        });

        Package::create([
            'package_name' => 'Premium Plan',
            'type' => 'Annually',
            'duration' => 'Billed Annually',
            'description' => 'PRO badge',
            'package_amount' => '25',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
