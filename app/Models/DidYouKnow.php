<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DidYouKnow extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function business_user()
    {
        return $this->belongsTo(User::class)->where('user_type','business');
    }

}
