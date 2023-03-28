<?php

namespace App\Repositories;

use App\Models\ReminderLogs;
use Illuminate\Support\Carbon;
use App\Models\StretchReminder;
use App\Interfaces\StretchRepositoryInterface;

class StretchRepository implements StretchRepositoryInterface
{

    public function setReminder(array $reminderDetails)
    {

        $input['wakeup_time'] = $reminderDetails['wakeup_time'];
        $input['sleepingHour'] =  $reminderDetails['sleepingHour'];
        $input['interval'] =  $reminderDetails['interval'];
        $input['reminderTime'] =  $reminderDetails['reminderTime'];
        $input['reminder_with_alarm'] =  $reminderDetails['reminder_with_alarm'];
        $input['user_id'] =  auth()->user()->id;
        $input['status'] =  1;

        $data = StretchReminder::create($input);
        $log = ReminderLogs::create(['user_id' => auth()->user()->id, 'reminder_date' => Carbon::now()->format('d-m-y')]);
        $input['reminderable_id'] = $data->id;

        return $data->reminder()->save($log);
    }

    public function updateReminder($reminderId, array $newreminder)
    {
        return StretchReminder::whereId($reminderId)->update($newreminder);
    }
}
