<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "transaction";

    protected $fillable = [
        'transitionable_id',
        'transitionable_type',
        'transactor',
        'status',
        'amount',
        'description',
        'transaction_id',
        'package_id',
        'feature_expiry_date',
    ];

    protected $appends = ['is_featured'];

    public function transitionable()
    {
        return $this->morphTo();
    }

    public function Feature()
    { 
        return $this->belongsTo(Features::class,'package_id');
    }


    public function UserArtist()
    { 
        return $this->belongsTo(UserArtist::class,'transitionable_id');
    }

    
    public function getIsFeaturedAttribute()
    {
        return'hi';
        return UserProfile::where('id',$this->user_profile_id)->pluck('name')->first();
    }
 
}
