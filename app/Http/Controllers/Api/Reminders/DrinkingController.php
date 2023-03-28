<?php

namespace App\Http\Controllers\Api\Reminders;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\ReminderLogs;
use Illuminate\Http\Request;
use App\Models\DrinkingReminder;
use App\Notifications\AdminNotify;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class DrinkingController extends Controller
{



    public function listDrinkingReminder()
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $data = DrinkingReminder::all();
            if ($data) {
                return api_success('Reminders', $data);
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function setDrinkingReminder(Request $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $input['water_intake_amount'] = $request->water_intake_amount;
            $input['wakeup_time'] =  $request->wakeup_time;
            $input['sleeping_hour'] =  $request->sleeping_hour;
            $input['interval'] =  $request->interval;
            $input['other_interval_minutes'] =  $request->other_interval_minutes;
            $input['remind_time'] =  $request->remind_time;
            $input['reminder_with_alarm'] =  $request->reminder_with_alarm == 1 ? 1 : 0;
            $input['user_id'] =  auth()->user()->id;
            $input['status'] = 1;

            $data = DrinkingReminder::create($input);

            $admin_notify = Admin::where('id', 1)->first();
            Notification::send($admin_notify, new AdminNotify([
                'title' => 'New Drinking Reminder Added',
                'message' => 'User Id: ' . $data->id,
                'id' => $data->id,
                'route' => 'admin.users.show',

            ]));

            $log = ReminderLogs::create(['user_id' => auth()->user()->id, 'reminder_date' => Carbon::now()->format('d-m-y')]);
            $input['reminderable_id'] = $data->id;
            if ($data->reminder()->save($log)) {
                return api_success('Reminder Set Successfully', $data);
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function updateDrinkingReminder(Request $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $data =  $request->only(['water_intake_amount', 'wakeup_time', 'sleeping_hour', 'interval', 'other_interval_minutes', 'remind_time', 'reminder_with_alarm', 'status']);

            $dataSaved = DrinkingReminder::where('id', $request->waterReminderId)->update($data);

            if ($dataSaved) {
                return api_success('Reminder Updated Successfully', $data);
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function setDrinkingNotification()
    {
        $search = '';
        if (request()->has('type')) {
            if (request('type') == 'drinking') {
                $search = 'App\Models\DrinkingReminder';
            } else {
                return api_success1('Record Not Found.');
            }
        }

        $check = ReminderLogs::with('reminderable')
            ->when(request()->filled('type'), function ($q) use ($search) {
                $q->whereHasMorph('reminderable', $search);
            })
            ->where('reminderable_id', request('id'))
            ->where('user_id', auth()->user()->id)
            ->update(['completed' => request('completed') ?? false, 'snooze_status' => request('snooze') ?? false]);
        if ($check) {
            $getData = ReminderLogs::with('reminderable')
                ->when(request()->filled('type'), function ($q) use ($search) {
                    $q->whereHasMorph('reminderable', $search);
                })
                ->where('reminderable_id', request('id'))
                ->where('user_id', auth()->user()->id)->first();
            return api_success('Drinking Notification Set Successfully', $getData);
        }
        return api_success1('Reminder Not Found.');
    }
}
