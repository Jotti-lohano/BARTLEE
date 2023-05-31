<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistSkills extends Model
{
    use HasFactory;


    protected $fillable = ['user_artist_id','skill_id'];


    public function skill()
    {
        return $this->belongsTo(Skills::class);
    }

}
