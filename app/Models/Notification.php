<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $table = 'notifications';

    protected $casts = [
        'data' => 'json',
        // 'created_at' => 'datetime: H:i',
        'id' => 'string'
    ];

}
