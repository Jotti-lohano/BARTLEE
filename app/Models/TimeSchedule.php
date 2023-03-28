<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSchedule extends Model
{
    use HasFactory;

    protected $table = 'reminder_time_schedule';

    protected $fillable = ['reminder_id','reminder_time'];
}
