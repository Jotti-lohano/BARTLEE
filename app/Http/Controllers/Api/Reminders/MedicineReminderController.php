<?php

namespace App\Http\Controllers\Api\Reminders;

use DateTime;
use App\Models\User;
use App\Models\Admin;
use App\Models\Medicine;
use App\Models\ReminderLogs;
use App\Models\TimeSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\JoggingReminder;
use App\Models\StretchReminder;
use App\Models\DrinkingReminder;
use App\Models\MedicineReminder;
use App\Notifications\AdminNotify;
use Illuminate\Support\Facades\DB;
use App\Models\AppointmentReminder;
use App\Http\Controllers\Controller;
use App\Core\Notifications\PushNotification;
use App\Models\MedicineReminderDays;
use Illuminate\Support\Facades\Notification;

class MedicineReminderController extends Controller
{

    public function getMedicineNotification()
    {

        $now = Carbon::now()->format('H:i');
        $nowPlusFive = Carbon::now()->addMinutes(5)->format('H:i');
        return $nowPlusFive;
        $date = Carbon::now()->format('Y-m-d');
        $day = Carbon::parse($date)->format('l');
        // $date = "2022-11-18 00:00:00";
        // $now = "13:00";
        // $day = "Monday";


        $medicine = MedicineReminder::join('reminder_time_schedule', 'reminder_time_schedule.reminder_id', '=', 'medicine_reminder.id')
            ->join('reminder_log', 'reminder_log.reminderable_id', '=', 'medicine_reminder.id')
            ->join('medicine_reminder_days', 'medicine_reminder_days.reminder_id', '=', 'medicine_reminder.id')
            ->where('reminder_log.snooze_status', 1)
            ->where('reminder_log.reminderable_type', "App\Models\MedicineReminder")
            ->get();


        foreach ($medicine as $get_time) {

            //check current day with set day

            if ($day == $get_time->days) {

                // check duration start date and end date

                if ($date >= $get_time->start_date && $date <= $get_time->end_date) {

                    // check how many time remind me and notify Onec Time

                    if ($get_time->remind_me == 'Once') {

                        $snoozeTime = Carbon::parse($get_time->reminder_time)->format('H:i');
                        $user = User::whereId($get_time->user_id)->first();
                        if ($snoozeTime == $now) {
                            $data['data'] = [
                                'id' =>  $get_time->medicine_id,
                                'type' => 'medicine',
                                'alarm' => true,
                                'title' => 'medicine',
                            ];
                            $user->notify(new PushNotification(
                                'Medicine Reminder',
                                'Take Your Medicine',
                                $data
                            ));
                            return 'Reminder Sended';
                        }
                    }

                    // check how many time remind me and notify Twice Time

                    elseif ($get_time->remind_me == 'Twice') {
                        $snoozeTimeFirst = Carbon::parse($get_time->reminder_time)->format('H:i');
                        $snoozeTimeSecond = Carbon::parse($get_time->reminder_time)->addMinutes(20)->format('h:i');
                        $user = User::whereId($get_time->user_id)->first();
                        if (in_array($now, [$snoozeTimeFirst, $snoozeTimeSecond], true)) {
                            $data['data'] = [
                                'id' =>  $get_time->medicine_id,
                                'type' => 'medicine',
                                'alarm' => true,
                                'title' => 'medicine',
                            ];
                            $user->notify(new PushNotification(
                                'Medicine Reminder',
                                'Take Your Medicine',
                                $data
                            ));
                        }
                    } elseif ($get_time->remind_me == 'Thrice') {
                        $snoozeTimeFirst = Carbon::parse($get_time->reminder_time)->format('H:i');
                        $snoozeTimeSecond = Carbon::parse($get_time->reminder_time)->addMinutes(10)->format('h:i');
                        $snoozeTimeThird = Carbon::parse($get_time->reminder_time)->addMinutes(20)->format('h:i');
                        $user = User::whereId($get_time->user_id)->first();
                        if (in_array($now, [$snoozeTimeFirst, $snoozeTimeSecond, $snoozeTimeThird], true)) {
                            $data['data'] = [
                                'id' =>  $get_time->medicine_id,
                                'type' => 'medicine',
                                'alarm' => true,
                                'title' => 'medicine',
                            ];
                            $user->notify(new PushNotification(
                                'Medicine Reminder',
                                'Take Your Medicine',
                                $data
                            ));
                        }
                    }
                }
            }
        }
    }

    public function getStretchNotification()
    {

        $now = Carbon::now()->format('H:i');
        // $now = '13:00';

        $stretch = StretchReminder::join('reminder_log', 'reminder_log.reminderable_id', '=', 'stretch_reminder.id')
            ->where('reminder_log.snooze_status', 1)
            ->where('stretch_reminder.status', 1)
            ->where('reminder_log.reminderable_type', "App\Models\StretchReminder")
            ->get();

        if ($stretch) {
            foreach ($stretch as $get_time) {
                $snoozeTimeFirst = Carbon::parse($get_time->reminderTime)->format('H:i');
                $snoozeTimeSecond = Carbon::parse($get_time->reminderTime)->addMinutes(10)->format('h:i');
                $snoozeTimeThird = Carbon::parse($get_time->reminderTime)->addMinutes(20)->format('h:i');

                $startTime = Carbon::parse($get_time->wakeup_time)->format('H:i');
                $endTime = Carbon::parse($get_time->sleepingHour)->format('H:i');
                $user = User::where('id', $get_time->user_id)->first();
                if ($now >=  $startTime && $now <= $endTime) {
                    if ($user) {
                        if ($get_time->interval == 'Once') {

                            if ($snoozeTimeFirst == $now) {
                                return 'ok';
                                $data['data'] = [
                                    'id' => 1,
                                    'type' => 'posture',
                                    'alarm' => true,
                                    'title' => 'posture',
                                ];
                                $user->notify(new PushNotification(
                                    'Stretch Reminder',
                                    'Its Exercise Time',
                                    $data
                                ));
                            }
                        }
                        if ($get_time->interval == 'Twice') {
                            if (in_array($now, [$snoozeTimeFirst, $snoozeTimeSecond], true)) {
                                $data['data'] = [
                                    'id' => 1,
                                    'type' => 'posture',
                                    'alarm' => true,
                                    'title' => 'posture',
                                ];
                                $user->notify(new PushNotification(
                                    'Stretch Reminder',
                                    'Its Exercise Time',
                                    $data
                                ));
                            }
                        }
                        if ($get_time->interval == 'Thrice') {
                            if (in_array($now, [$snoozeTimeFirst, $snoozeTimeSecond, $snoozeTimeThird], true)) {
                                $data['data'] = [
                                    'id' => 1,
                                    'type' => 'posture',
                                    'alarm' => true,
                                    'title' => 'posture',
                                ];
                                $user->notify(new PushNotification(
                                    'Stretch Reminder',
                                    'Its Exercise Time',
                                    $data
                                ));
                            }
                        }
                    }
                }
            }
            return $stretch;
        }
    }

    public function getDrinkingNotification()
    {

        $now = Carbon::now()->format('H:i');

        $water = DrinkingReminder::join('reminder_log', 'reminder_log.reminderable_id', '=', 'drinking_reminder.id')
            ->where('reminder_log.snooze_status', 1)
            ->where('drinking_reminder.status', 1)
            ->where('reminder_log.reminderable_type', "App\Models\DrinkingReminder")
            ->get();

        return $water;

        if ($water) {
            foreach ($water as $get_time) {
                $snoozeTimeFirst = Carbon::parse($get_time->wakeup_time)->addMinutes($get_time->interval)->format('H:i');
                $snoozeTimeSecond = Carbon::parse($get_time->wakeup_time)->addMinutes($get_time->interval + $get_time->interval)->format('H:i');
                $snoozeTimeThird = Carbon::parse($get_time->wakeup_time)->addMinutes($get_time->interval + $get_time->interval + $get_time->interval)->format('H:i');

                $startTime = Carbon::parse($get_time->wakeup_time)->format('H:i');
                $endTime = Carbon::parse($get_time->sleeping_hour)->format('H:i');
                $user = User::where('id', $get_time->user_id)->first();
                if ($now >=  $startTime && $now <= $endTime) {
                    if ($user) {
                        if ($get_time->interval == 'Once') {
                            if ($snoozeTimeFirst == $now) {

                                $data['data'] = [
                                    'id' =>  $get_time->id,
                                    'type' => 'drinking',
                                    'alarm' => true,
                                    'title' => 'drinking',
                                ];
                                $user->notify(new PushNotification(
                                    'Drinking Reminder',
                                    'Its Drinking Time',
                                    $data
                                ));
                            }
                        }
                        if ($get_time->interval == 'Twice') {
                            if (in_array($now, [$snoozeTimeFirst, $snoozeTimeSecond], true)) {

                                $data['data'] = [
                                    'id' =>  $get_time->id,
                                    'type' => 'drinking',
                                    'alarm' => true,
                                    'title' => 'drinking',
                                ];
                                $user->notify(new PushNotification(
                                    'Drinking Reminder',
                                    'Its Drinking Time',
                                    $data
                                ));
                            }
                        }
                        if ($get_time->interval == 'Thrice') {
                            if (in_array($now, [$snoozeTimeFirst, $snoozeTimeSecond, $snoozeTimeThird], true)) {
                                $data['data'] = [
                                    'id' =>  $get_time->id,
                                    'type' => 'drinking',
                                    'alarm' => true,
                                    'title' => 'drinking',
                                ];
                                $user->notify(new PushNotification(
                                    'Drinking Reminder',
                                    'Its Drinking Time',
                                    $data
                                ));
                            }
                        }
                    }
                }
            }
        }
    }

    public function getJoggingNotification()
    {

        $now = Carbon::now()->format('H:i');
        $date = Carbon::now()->format('Y-m-d');
        $day = Carbon::parse($date)->format('l');
        // $date = "2022-11-18 00:00:00";
        // $now = "01:00";
        // $day = "Tuesday";

        $jogging = JoggingReminder::join('jogging_days', 'jogging_days.jogging_id', '=', 'jogging_reminder.id')
            ->join('reminder_log', 'reminder_log.reminderable_id', '=', 'jogging_reminder.id')
            ->where('reminder_log.snooze_status', 1)
            ->where('jogging_reminder.status', 1)
            ->where('reminder_log.reminderable_type', "App\Models\JoggingReminder")
            ->get();
        // return $jogging;

        if ($jogging) {
            foreach ($jogging as $get_time) {
                if ($date <= $get_time->end_date) {
                    if ($day == $get_time->days) {

                        $snoozeTimeFirst = Carbon::parse($get_time->remindTime)->format('H:i');
                        $snoozeTimeSecond = Carbon::parse($get_time->remindTime)->addMinutes(10)->format('h:i');
                        $snoozeTimeThird = Carbon::parse($get_time->remindTime)->addMinutes(20)->format('h:i');
                        $user = User::whereId($get_time->user_id)->first();
                        if ($get_time->interval == 'Once') {
                            if ($snoozeTimeFirst == $now) {
                                $data['data'] = [
                                    'id' =>  $get_time->id,
                                    'type' => 'jogging',
                                    'alarm' => true,
                                    'title' => 'jogging',
                                ];
                                $user->notify(new PushNotification(
                                    'jogging',
                                    'jogging',
                                    $data
                                ));
                            }
                        } elseif ($get_time->interval == 'Twice') {

                            if (in_array($now, [$snoozeTimeFirst, $snoozeTimeSecond], true)) {
                                $data['data'] = [
                                    'id' =>  $get_time->id,
                                    'type' => 'jogging',
                                    'alarm' => true,
                                    'title' => 'jogging',
                                ];
                                $user->notify(new PushNotification(
                                    'jogging',
                                    'jogging',
                                    $data
                                ));
                            }
                        } elseif ($get_time->interval == 'Thrice') {

                            if (in_array($now, [$snoozeTimeFirst, $snoozeTimeSecond, $snoozeTimeThird], true)) {
                                $data['data'] = [
                                    'id' =>  $get_time->id,
                                    'type' => 'jogging',
                                    'alarm' => true,
                                    'title' => 'jogging',
                                ];
                                $user->notify(new PushNotification(
                                    'jogging',
                                    'jogging',
                                    $data
                                ));
                            }
                        }
                    }
                }
            }
        }
    }

    public function getAppointmentNotification()
    {
        $now = Carbon::now()->format('H:i');
        $date = Carbon::now()->format('Y-m-d');

        $appointment = AppointmentReminder::join('appointment_time', 'appointment_time.appointment_id', '=', 'appointment_reminder.id')
            ->join('reminder_log', 'reminder_log.reminderable_id', '=', 'appointment_reminder.id')
            ->join('appointment_dates', 'appointment_dates.appointment_id', '=', 'appointment_reminder.id')
            ->where('reminder_log.snooze_status', 1)
            ->where('reminder_log.reminderable_type', "App\Models\AppointmentReminder")
            ->get();

        foreach ($appointment as $get_time) {
            $app_date =  Carbon::parse($get_time->reminder_date)->format('Y-m-d');
            $snoozeTime = Carbon::parse($get_time->reminder_time)->format('H:i');
            $user = User::where('id', $get_time->user_id)->first();
            if ($date ==  $app_date) {
                if ($now ==  $snoozeTime) {
                    $data['data'] = [
                        'id' =>  $get_time->id,
                        'type' => 'appointment',
                        'alarm' => true,
                        'title' => 'appointment',
                    ];
                    $user->notify(new PushNotification(
                        'appointment',
                        'appointment',
                        $data
                    ));
                }
            }
        }
    }


    public function setMedicineReminder(Request $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }
        try {

            if ($request->duration == 'Days') {

                $end_date = Carbon::parse($request->start_date)->addDays($request->duration_number);
            } elseif ($request->duration == 'Weeks') {

                $end_date = Carbon::parse($request->start_date)->addWeeks($request->duration_number);
            } else {

                $end_date = Carbon::parse($request->start_date)->addMonths($request->duration_number);
            }


            $medicine = Medicine::where('id', $request->medicine_id)->first();
            if (!$medicine) {
                return api_error('Medicine Not Found');
            }
            $input['medicine_id'] = $request->medicine_id;
            $input['duration'] =  $request->duration;
            $input['interval'] =  $request->interval;
            $input['duration_number'] =  $request->duration_number;
            $input['remind_me'] =  $request->remind_me;
            $input['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d 00:00:00');
            $input['end_date'] =  $end_date;
            $input['notes'] =  $request->notes ?? '';
            $input['user_id'] =  auth()->user()->id;
            $input['status'] =  1;

            $data = MedicineReminder::create($input);

            $log = ReminderLogs::create(['user_id' => auth()->user()->id, 'reminder_date' => Carbon::now()->format('d-m-y')]);
            $input['reminderable_id'] = $data->id;

            if ($data->reminder()->save($log)) {

                if (request('time_schedule')) {
                    foreach ($request->time_schedule as $time) {
                        $time_data[] = ['reminder_time' => $time, 'reminder_id' => $data->id,];
                    }

                    $data->time_schedule()->createMany($time_data);
                }

                if (request('days')) {

                    foreach ($request->days as $day) {
                        $days_data[] = ['days' => $day, 'reminder_id' => $data->id,];
                    }

                    $data->days()->createMany($days_data);
                }



                $lastest_appointment = MedicineReminder::with('time_schedule', 'days')->latest()->first();

                $admin_notify = Admin::where('id', 1)->first();
                Notification::send($admin_notify, new AdminNotify([
                    'title' => 'New Medicine Reminder Added',
                    'message' => 'User Id: ' . $data->id,
                    'id' => $data->id,
                    'route' => 'admin.users.show',

                ]));

                return api_success('Reminder Set Successfully', $lastest_appointment);
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function updateMedicineReminder(Request $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            if ($request->duration == 'Days') {

                $end_date = Carbon::parse($request->start_date)->addDays($request->duration_number);
            } elseif ($request->duration == 'Weeks') {

                $end_date = Carbon::parse($request->start_date)->addWeeks($request->duration_number);
            } else {

                $end_date = Carbon::parse($request->start_date)->addMonths($request->duration_number);
            }


            $data =  $request->only(['medicine_id', 'interval', 'duration', 'duration_number', 'remind_me', 'start_date', 'notes', 'status', 'end_date']);
            $data['end_date'] = $end_date;
            $dataSaved = MedicineReminder::where('id', $request->reminder_id)->update($data);

            $getMed = MedicineReminder::where('id', $request->reminder_id)->first();

            if ($dataSaved) {
                if (request('time_schedule')) {
                    TimeSchedule::where('reminder_id', $getMed->id)->delete();
                    foreach ($request->time_schedule as $time) {
                        $time_data[] = ['reminder_time' => $time, 'reminder_id' => $getMed->id];
                    }
                    $getMed->time_schedule()->createMany($time_data);
                }
                if (request('days')) {
                    MedicineReminderDays::where('reminder_id', $getMed->id)->delete();

                    foreach ($request->days as $day) {
                        $days_data[] = ['days' => $day, 'reminder_id' => $getMed->id,];
                    }
                    $getMed->days()->createMany($days_data);
                }
                $lastest_appointment = MedicineReminder::with('time_schedule', 'days')->where('medicine_id', $request->medicine_id)->first();

                return api_success('Reminder Updated Successfully', $lastest_appointment);
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function setMedicineNotification()
    {
        $search = '';
        if (request()->has('type')) {
            if (request('type') == 'medicine') {
                $search = 'App\Models\MedicineReminder';
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
            return api_success('Medicine Notification Set Successfully', $getData);
        }
        return api_success1('Reminder Not Found.');
    }
}
