<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderLogs extends Model
{
    use HasFactory;

    protected $table = 'reminder_log';

    protected $fillable = ['reminderable_id','reminderable_type','user_id','reminder_date','status','snooze_status'];

    

    public function reminderable()
    {
        return $this->morphTo();

    }


}
