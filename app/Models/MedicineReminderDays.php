<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineReminderDays extends Model
{
    use HasFactory;

    protected $table = 'medicine_reminder_days';

    protected $fillable = ['days', 'reminder_id'];
}
