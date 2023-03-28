<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPackages extends Model
{
    use HasFactory;

    protected $table = 'user_package';

    protected $fillable = ['user_id', 'package_id', 'status', 'purchase_date', 'expire_date'];


    public function transaction()
    {
        return $this->morphOne('App\Models\Transaction', 'transitionable');
    }

    public function subscriber()
    {
        return $this->belongsTo(UserProfile::class, 'user_id', 'user_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'package_id');
    }
}
