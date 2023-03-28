<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('last_name')->nullable()->after('name');
            $table->integer('is_admin_type')->default(0)->comment('1 is for super admin 0 is for sub admin')->after('last_name');
            $table->longText('permissions')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {

            $table->dropColumn(['last_name' ,'is_admin_type' ,'permissions']);

        });
    }
}
