<?php

namespace App\Http\Controllers\Api\Reminders;

use App\Models\Admin;
use App\Models\ReminderLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AppointmentDates;
use App\Notifications\AdminNotify;
use App\Models\AppointmentReminder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class AppointmentController extends Controller
{

    public function listAppointmentReminder()
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $data = AppointmentReminder::with('appointment_dates', 'appointment_times')->where('user_id', auth()->user()->id)->get();
            if ($data) {
                return api_success('Reminders', $data);
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function getAppointmentReminder(Request $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $data = AppointmentReminder::with('appointment_dates', 'appointment_times')->where('id', $request->appointment_id)->where('user_id', auth()->user()->id)->first();
            if ($data) {
                return api_success('Reminders', $data);
            } else {
                return api_success1('Reminders Not Exist');
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function setAppointmentReminder(Request $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $input['appointment_title'] = $request->appointment_title;
            $input['doctor_name'] =  $request->doctor_name ?? '';
            $input['category'] =  $request->category ?? '';
            $input['location'] =  $request->location ?? '';
            $input['hospital_name'] =  $request->hospital_name;
            $input['room_number'] =  $request->room_number ?? '';
            $input['contact_number'] =  $request->contact_number ?? '';
            $input['email'] =  $request->email ?? '';
            $input['notes'] =  $request->notes;
            $input['status'] =  1;
            $input['user_id'] =  auth()->user()->id;
            $input['days_to_visit'] =  $request->days_to_visit;
            $input['visit_time'] =  $request->visit_time;


            $data = AppointmentReminder::create($input);

            $log = ReminderLogs::create(['user_id' => auth()->user()->id, 'reminder_date' => Carbon::now()->format('d-m-y')]);
            $input['reminderable_id'] = $data->id;
            if ($data->reminder()->save($log)) {

                if (request()->has('reminder_date')) {
                    foreach ($request->reminder_date as $date) {
                        $appointment_data[] = ['reminder_date' => $date, 'appointment_id' => $data->id,];
                    }
                    $data->appointment_dates()->createMany($appointment_data);

                    foreach ($request->reminder_time as $time) {
                        $appointment_time[] = ['reminder_time' => $time, 'appointment_id' => $data->id,];
                    }
                    $data->appointment_times()->createMany($appointment_time);
                }

                $lastest_appointment = AppointmentReminder::with('appointment_dates', 'appointment_times')->latest()->first();

                $admin_notify = Admin::where('id', 1)->first();
                Notification::send($admin_notify, new AdminNotify([
                    'title' => 'New Appointment Reminder Added',
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

    public function updateAppointmentReminder(Request $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $data =  $request->only([
                'appointment_title', 'doctor_name', 'category', 'hospital_name', 'location', 'room_number', 'contact_number', 'email', 'notes', 'days_to_visit', 'visit_time', 'status'
            ]);

            $dataSaved = AppointmentReminder::where('id', $request->appointment_id)->update($data);

            $getMed = AppointmentReminder::where('id', $request->appointment_id)->first();

            if ($dataSaved) {
                if (request('reminder_date')) {
                    AppointmentDates::where('appointment_id', $getMed->id)->delete();
                    foreach ($request->reminder_date as $date) {
                        $appointment_data[] = ['reminder_date' => $date, 'appointment_id' => $getMed->id,];
                    }
                    $getMed->appointment_dates()->createMany($appointment_data);

                    foreach ($request->reminder_time as $time) {
                        $appointment_time[] = ['reminder_time' => $time, 'appointment_id' => $request->appointment_id,];
                    }
                    $getMed->appointment_times()->createMany($appointment_time);
                }
                $lastest_appointment = AppointmentReminder::with('appointment_dates', 'appointment_times')->where('id', $request->appointment_id)->first();

                return api_success('Reminder Updated Successfully', $lastest_appointment);
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function setAppointmentNotification()
    {
        $search = '';
        if (request()->has('type')) {
            if (request('type') == 'appointment') {
                $search = 'App\Models\AppointmentReminder';
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
            ->update(['completed' => request('completed') ?? false, 'later' => request('later') ?? false]);
        if ($check) {
            $getData = ReminderLogs::with('reminderable')
                ->when(request()->filled('type'), function ($q) use ($search) {
                    $q->whereHasMorph('reminderable', $search);
                })
                ->where('reminderable_id', request('id'))
                ->where('user_id', auth()->user()->id)->first();
            return api_success('Appointment Notification Set Successfully', $getData);
        }
        return api_success1('Reminder Not Found.');
    }
}
