<?php
namespace Database\Seeders;
use App\Models\BusinessType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       BusinessType::create([
            'business_type' => 'Electronic',
           
        ]);

        BusinessType::create([
            'business_type' => 'MusicType',
        
        ]);
        BusinessType::create([
            'business_type' => 'VideoType',
        
        ]);
    }
}