<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserArtist extends Model
{
    use HasFactory;
    protected $appends = ['artist_name'];

    public function artist_profession()
    {
        return $this->belongsTo(Profession::class,'artist_profession');
    }

    public function artist_skills()
    {
        return $this->hasMany(ArtistSkills::class, 'user_artist_id');
    }

    public function artist_work()
    {
        return $this->hasMany(ArtistWork::class, 'user_artist_id');
    }

    public function paymentTransaction()
    {
        return $this->morphOne(Transaction::class, 'transitionable');
    }

    public function getArtistNameAttribute()
    {
        
        return UserProfile::where('id',$this->user_profile_id)->pluck('name')->first();
    }

    public function UserProfile()
    {
       return $this->belongsTo(UserProfile::class);
    }

}
