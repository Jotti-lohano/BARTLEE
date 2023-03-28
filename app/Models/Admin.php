<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $fillable = ['name','last_name','email','password', 'status'];
    protected $appends = ['status_detail','url'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */

    protected $uploads = 'user/avatar/';

 
    protected $statuses = [
        0 => 'Inative',
        1 => 'Active',
    ];

    public function getStatusDetailAttribute(){
        return $this->statuses[$this->status];
    }

    public function getUrlAttribute($image)
    {
        return url(\Storage::url($this->uploads . $this->avatar));
    }

}
