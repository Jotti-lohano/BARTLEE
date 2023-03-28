<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrinkingReminder extends Model
{
    use HasFactory;

    protected $table = 'drinking_reminder';

    protected $fillable = ['user_id','water_intake_amount','wakeup_time','sleeping_hour','interval','other_interval_minutes','remind_time','reminder_with_alarm','status'];
    protected $appends = ['type'];

    public function reminder()
    {
        return $this->morphOne('App\Models\ReminderLogs', 'reminderable');
    }
    public function getTypeAttribute(){
        return $this->type = 'Drinking Reminder';
    }

    public function days()
    {
        return $this->belongsTo(JoggingDays::class, 'jogging_id');
    }


}
