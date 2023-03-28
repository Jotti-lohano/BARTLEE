<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentDates extends Model
{
    use HasFactory;

    protected $table = 'appointment_dates';

    protected $fillable = ['appointment_id','reminder_date'];

   

}
