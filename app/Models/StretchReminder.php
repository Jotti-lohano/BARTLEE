<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StretchReminder extends Model
{
    use HasFactory;

    protected $table = 'stretch_reminder';

    protected $fillable = ['user_id', 'wakeup_time', 'sleepingHour', 'interval', 'reminderTime', 'reminder_with_alarm', 'status'];

    protected $appends = ['type'];


    public function reminder()
    {
        return $this->morphOne('App\Models\ReminderLogs', 'reminderable');
    }

    public function getTypeAttribute()
    {
        return $this->type = 'Stretch Reminder';
    }

    public function days()
    {
        return $this->belongsTo(JoggingDays::class, 'jogging_id');
    }
}
