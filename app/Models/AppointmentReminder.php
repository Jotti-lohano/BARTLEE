<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentReminder extends Model
{
    use HasFactory;

    protected $table = 'appointment_reminder';

    protected $fillable = [
        'user_id', 'appointment_title', 'doctor_name', 'category', 'hospital_name', 'location', 'room_number', 'contact_number', 'email', 'notes', 'days_to_visit', 'visit_time', 'status'
    ];

    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return $this->type = 'Appointment Reminder';
    }

    public function appointment_dates()
    {
        return $this->hasMany(AppointmentDates::class, 'appointment_id');
    }

    public function appointment_times()
    {
        return $this->hasMany(AppointmentTime::class, 'appointment_id');
    }

    public function reminder()
    {
        return $this->morphOne('App\Models\ReminderLogs', 'reminderable');
    }


    public function time_schedule()
    {
        return $this->hasMany(AppointmentTime::class, 'appointment_id');
    }

    public function days()
    {
        return $this->hasMany(MedicineReminderDays::class, 'id');
    }
}
