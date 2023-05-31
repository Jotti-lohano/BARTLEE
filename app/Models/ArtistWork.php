<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistWork extends Model
{
    use HasFactory;

    protected $fillable = ['user_artist_id','content'];

    protected $appends = ['profession'];

    public function getProfessionAttribute()
   {
       
       $grade = Profession::where('id',$this->artist_profession)->pluck('Profession')->first();
       return $grade;
   }

}
