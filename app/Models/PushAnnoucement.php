<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushAnnoucement extends Model
{
    use HasFactory;

    protected $fillable = ['image' ,'name','status'];
    
    protected $appends = ['status_detail'];
    
    
    protected $statuses = [
        0 => 'Inative',
        1 => 'Active',
    ];

    public function getStatusDetailAttribute(){
        return $this->statuses[$this->status];
    }
}
