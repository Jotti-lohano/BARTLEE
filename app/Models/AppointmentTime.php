<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentTime extends Model
{
    use HasFactory;

    protected $table = 'appointment_time';

    protected $fillable = ['appointment_id','reminder_time'];
}
