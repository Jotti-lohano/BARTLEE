<?php

namespace App\Console\Commands;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\JoggingReminder;
use App\Models\StretchReminder;
use Illuminate\Console\Command;
use App\Models\DrinkingReminder;
use App\Models\MedicineReminder;
use App\Models\AppointmentReminder;
use App\Core\Notifications\PushNotification;

class SendReminderNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jogging:reminder';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Jogging Reminder';

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
        $this->info($this->sendDrinkingReminder());
        $this->sendJoggingReminder();
        $this->sendStretchReminder();
        $this->sendAppointmentReminder();
        $this->sendDrinkingReminder();
        $this->sendMedicneReminder();
    }

    public function sendJoggingReminder()
    {
        $now = Carbon::now()->format('H:i');
        // $now = '13:00';

        $jogging = JoggingReminder::with('reminder')->where('status', 1)->get();
        if ($jogging) {
            foreach ($jogging as $get_time) {
                $new_time = DateTime::createFromFormat('h:i A', $get_time->jogging_time);
                $alertTime = $new_time->format('H:i');
                $user = User::where('id', $get_time->user_id)->first();
                if ($user) {
                    if ($now >= $alertTime) {

                        $data['data'] = [
                            'id' =>  $get_time->id,
                            'type' => 'jogging',
                            'alarm' => true,
                            'title' => 'jogging',
                        ];
                        $user->notify(new PushNotification(
                            'Jogging Reminder',
                            'Its Jogging Time',
                            $data
                        ));
                    }
                }
            }
            return $jogging;
        }
    }
    public function sendMedicneReminder()
    {

        $now = Carbon::now()->format('H:i');
        // $now = '09:00';
        $medicine = MedicineReminder::with('time_schedule')->where('status', 1)->get();
        if ($medicine) {
            foreach ($medicine as $get_time) {
                $user = User::where('id', $get_time->user_id)->first();
                if ($user) {
                    foreach ($get_time->time_schedule as $time) {
                        $new_time = DateTime::createFromFormat('h:i A', $time->reminder_time);
                        $alertTime = $new_time->format('H:i');
                        if ($alertTime == $now) {
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

            return $medicine;
        }
    }

    public function sendStretchReminder()
    {
        $now = Carbon::now()->format('H:i');
        // $now = '22:00';
        $stretch = StretchReminder::where('status', 1)->get();
        if ($stretch) {
            foreach ($stretch as $get_time) {
                $new_time = DateTime::createFromFormat('h:i A', $get_time->reminderTime);
                $alertTime = $new_time->format('H:i');

                $user = User::where('id', $get_time->user_id)->first();
                if ($user) {
                    if ($alertTime == $now) {

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
            return $stretch;
        }
    }

    public function sendAppointmentReminder()
    {
        $now = Carbon::now()->format('H:i');
        // $now = '22:00';
        $appointment = AppointmentReminder::with('appointment_times')->where('status', 1)->get();
        if ($appointment) {
            foreach ($appointment as $get_time) {
                $user = User::where('id', $get_time->user_id)->first();
                if ($user) {
                    foreach ($get_time->appointment_times as $time) {

                        $new_time = DateTime::createFromFormat('h:i A', $time->reminder_time);

                        $alertTime = $new_time->format('H:i');
                        if ($alertTime == $now) {
                            $data['data'] = [
                                'id' =>  $get_time->id,
                                'type' => 'appointment',
                                'alarm' => true,
                                'title' => 'appointment',
                            ];
                            $user->notify(new PushNotification(
                                'Appointment Reminder',
                                'Your Appointment Reminder',
                                $data
                            ));
                        }
                    }
                }
            }

            return $appointment;
        }
    }

    public function sendDrinkingReminder()
    {
        $now = Carbon::now()->format('H:i');
        // $now = '22:00';
        $drinking = DrinkingReminder::where('status', 1)->get();
        if ($drinking) {
            foreach ($drinking as $get_time) {

                $new_time = DateTime::createFromFormat('h:i A', $get_time->remind_time);

                $alertTime = $new_time->format('H:i');
                $user = User::where('id', $get_time->user_id)->first();
                if ($user) {
                    if ($alertTime == $now) {

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
            return $drinking;
        }
    }
}
