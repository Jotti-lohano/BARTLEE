<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class business_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_company',
        'company_name',
        'business_type_id',
        'avatar',
    ];

     protected $appends = ['business_type'];

     public function getBusinessTypeAttribute()
    {
        
        $grade = BusinessType::where('id',$this->business_type_id)->pluck('business_type')->first();
        return $grade;
    }
}
