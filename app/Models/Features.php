<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    use HasFactory;

    public function FeatureList()
    {
        return $this->hasMany(FeatureList::class, 'feature_id');
    }

    

    
}
