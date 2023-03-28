<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoggingDays extends Model
{
    use HasFactory;

    protected $table = 'jogging_days';

    protected $fillable = ['days', 'jogging_id'];
}
