<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserBusiness;
use Illuminate\Database\Seeder;

class BusinessTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i =1;
        User::factory()->count(100)->create()->each(function ($company) use ($i){
            $company->business_user()->save(\App\Models\UserBusiness::factory()->make());
            $i++;
        });
    }
}
