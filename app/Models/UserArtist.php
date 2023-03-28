<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserArtist extends Model
{
    use HasFactory;

    public function artist_profession()
    {
        return $this->belongsTo(Profession::class,'artist_profession');
    }
}
