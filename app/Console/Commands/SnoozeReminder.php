<?php

namespace App\Console\Commands;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\ReminderLogs;
use App\Models\JoggingReminder;
use App\Models\StretchReminder;
use Illuminate\Console\Command;
use App\Models\DrinkingReminder;
use App\Models\MedicineReminder;
use App\Models\AppointmentReminder;
use App\Core\Notifications\PushNotification;

class SnoozeReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snooze:reminder';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Snooze Reminder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $this->info($this->sendJoggingReminder());
        $this->sendJoggingReminder();
        $this->sendStretchReminder();
        $this->sendAppointmentReminder();
        $this->sendDrinkingReminder();
        $this->sendMedicneReminder();
    }

    public function sendJoggingReminder()
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

        if ($jogging) {
            foreach ($jogging as $get_time) {
                if ($date <= $get_time->end_date) {
                    if ($day == $get_time->days) {

                        $snoozeTimeFirst = Carbon::parse($get_time->remindTime)->format('H:i');
                        $snoozeTimeSecond = Carbon::parse($get_time->remindTime)->addMinutes(10)->format('H:i');
                        $snoozeTimeThird = Carbon::parse($get_time->remindTime)->addMinutes(20)->format('H:i');
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
    public function sendMedicneReminder()
    {

        $now = Carbon::now()->format('H:i');
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

        if ($medicine) {
            foreach ($medicine as $get_time) {

                //check current day with set day

                if ($day == $get_time->days) {

                    // check duration start date and end date

                    if ($date >= $get_time->start_date && $date <= $get_time->end_date) {

                        // check how many time remind me and notify Onec Time
                        $snoozeTimeFirst = Carbon::parse($get_time->reminder_time)->format('H:i');
                        $snoozeTimeSecond = Carbon::parse($get_time->reminder_time)->addMinutes(10)->format('H:i');
                        $snoozeTimeThird = Carbon::parse($get_time->reminder_time)->addMinutes(20)->format('H:i');
                        $user = User::whereId($get_time->user_id)->first();

                        if ($get_time->remind_me == 'Once') {

                            if ($snoozeTimeFirst == $now) {
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

                        // check how many time remind me and notify Twice Time

                        elseif ($get_time->remind_me == 'Twice') {

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
    }

    public function sendStretchReminder()
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
                $snoozeTimeSecond = Carbon::parse($get_time->reminderTime)->addMinutes(10)->format('H:i');
                $snoozeTimeThird = Carbon::parse($get_time->reminderTime)->addMinutes(20)->format('H:i');

                $startTime = Carbon::parse($get_time->wakeup_time)->format('H:i');
                $endTime = Carbon::parse($get_time->sleepingHour)->format('H:i');
                $user = User::where('id', $get_time->user_id)->first();
                if ($now >=  $startTime && $now <= $endTime) {
                    if ($user) {
                        if ($get_time->interval == 'Once') {

                            if ($snoozeTimeFirst == $now) {
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

    public function sendAppointmentReminder()
    {
        $now = Carbon::now()->format('H:i');
        $date = Carbon::now()->format('Y-m-d');

        $appointment = AppointmentReminder::join('appointment_time', 'appointment_time.appointment_id', '=', 'appointment_reminder.id')
            ->join('reminder_log', 'reminder_log.reminderable_id', '=', 'appointment_reminder.id')
            ->join('appointment_dates', 'appointment_dates.appointment_id', '=', 'appointment_reminder.id')
            ->where('reminder_log.snooze_status', 1)
            ->where('reminder_log.reminderable_type', "App\Models\AppointmentReminder")
            ->get();
        if ($appointment) {
            foreach ($appointment as $get_time) {
                $app_date =  Carbon::parse($get_time->reminder_date)->format('Y-m-d');
                $snoozeTime = Carbon::parse($get_time->reminder_time)->format('H:i');
                $user = User::where('id', $get_time->user_id)->first();
                if ($user) {
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
        }
    }

    public function sendDrinkingReminder()
    {
        $now = Carbon::now()->format('H:i');

        $water = DrinkingReminder::join('reminder_log', 'reminder_log.reminderable_id', '=', 'drinking_reminder.id')
            ->where('reminder_log.snooze_status', 1)
            ->where('drinking_reminder.status', 1)
            ->where('reminder_log.reminderable_type', "App\Models\DrinkingReminder")
            ->get();

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
}
