<?php

namespace App\Http\Controllers\Api\Reminders;

use App\Models\Admin;
use App\Models\JoggingDays;
use App\Models\ReminderLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\JoggingReminder;
use App\Notifications\AdminNotify;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\PushNotification;
use Illuminate\Support\Facades\Notification;

class JoggingController extends Controller
{
    public function setJoggingReminder(Request $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            if ($request->duration_type == 'Days') {

                $end_date = Carbon::now()->addDays($request->duration_number);
            } elseif ($request->duration_type == 'Weeks') {

                $end_date = Carbon::now()->addWeeks($request->duration_number);
            } else {

                $end_date = Carbon::now()->addMonths($request->duration_number);
            }

            $input['jogging_time'] = $request->jogging_time;
            $input['interval'] =  $request->interval;
            $input['duration_type'] =  $request->duration_type;
            $input['duration_number'] =  $request->duration_number;
            $input['reminder_with_alarm'] =  $request->reminder_with_alarm == 1 ? 1 : 0;
            $input['remindTime'] =  $request->remindTime;
            $input['end_date'] =  $end_date;
            $input['user_id'] =  auth()->user()->id;
            $input['status'] = 1;

            $data = JoggingReminder::create($input);

            $log = ReminderLogs::create(['user_id' => auth()->user()->id, 'reminder_date' => Carbon::now()->format('d-m-y')]);
            $input['reminderable_id'] = $data->id;

            if ($data->reminder()->save($log)) {
                if ($request->days) {
                    foreach ($request->days as $day) {
                        $jogging_day[] = ['days' => $day, 'jogging_id' => $data->id,];
                    }
                    $data->days()->createMany($jogging_day);
                }
                $getApp = JoggingReminder::with('days')->latest()->first();

                $admin_notify = Admin::where('id', 1)->first();
                Notification::send($admin_notify, new AdminNotify([
                    'title' => 'New Jogging Reminder Added',
                    'message' => 'User Id: ' . $data->id,
                    'id' => $data->id,
                    'route' => 'admin.users.show',

                ]));

                return api_success('Reminder Set Successfully', $getApp);
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function updateJoggingReminder(Request $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            if ($request->duration_type == 'Days') {

                $end_date = Carbon::now()->addDays($request->duration_number);
            } elseif ($request->duration_type == 'Weeks') {

                $end_date = Carbon::now()->addWeeks($request->duration_number);
            } else {

                $end_date = Carbon::now()->addMonths($request->duration_number);
            }

            $data =  $request->only(['jogging_time', 'interval', 'duration_type', 'duration_number', 'remindTime', 'reminder_with_alarm', 'status', 'end_date']);
            $data['end_date'] = $end_date;
            $dataSaved = JoggingReminder::where('id', $request->jogging_id)->update($data);

            $getMed = JoggingReminder::with('days')->where('id', $request->jogging_id)->first();


            if ($dataSaved) {
                if (request('days')) {
                    JoggingDays::where('jogging_id', $getMed->id)->delete();
                    foreach ($request->days as $day) {
                        $jogging_day[] = ['days' => $day, 'jogging_id' => $getMed->id,];
                    }
                    $getMed->days()->createMany($jogging_day);
                }
                $getApp = JoggingReminder::with('days')->where('id', $request->jogging_id)->first();

                return api_success('Reminder Updated Successfully', $getApp);
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function setJoggingNotification()
    {

        $newYear = new Carbon('5 PM');
        // return $newYear;



        $search = '';
        if (request()->has('type')) {
            if (request('type') == 'jogging') {
                $search = 'App\Models\JoggingReminder';
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
            ->update(['going' => request('going') ?? false, 'snooze_status' => request('snooze') ?? false]);
        if ($check) {
            $getData = ReminderLogs::with('reminderable')
                ->when(request()->filled('type'), function ($q) use ($search) {
                    $q->whereHasMorph('reminderable', $search);
                })
                ->where('reminderable_id', request('id'))
                ->where('user_id', auth()->user()->id)->first();

            //jogging notification cron
            $user = auth()->user();
            // return $user;
            $user->notify(new PushNotification(
                'jogging',
                'jogging',
                [
                    'body' => $getData,
                    'type' => 'jogging',
                    'alarm' => true,
                    'title' => 'jogging',

                ]
            ));
            //jogging notification cron
            return api_success('Jogging Notification Set Successfully', $getData);
        }
        return api_success1('Reminder Not Found.');
    }
}
