<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

   protected $fillable = ['user_id','title','description','route'];
   protected $table = 'activity_logs';
   protected $casts = [
       'route' => 'json'
   ];
   protected $appends = ['formatted_created_at'];

   public function getFormattedCreatedAtAttribute(){
        $createdAt = \Carbon\Carbon::parse($this->created_at);
        $diff = $createdAt->diff();        
        if($diff->days <= 30){
            return $createdAt->diffForHumans();
        }
        return $createdAt->format('F jS Y');
   }
   
}
