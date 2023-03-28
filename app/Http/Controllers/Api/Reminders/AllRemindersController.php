<?php

namespace App\Http\Controllers\Api\Reminders;

use Barryvdh\DomPDF\PDF;
use App\Models\ReminderLogs;
use Illuminate\Http\Request;
use App\Core\Traits\Downloadable;
use Illuminate\Support\Facades\DB;
use App\Models\AppointmentReminder;
use App\Http\Controllers\Controller;
use App\Http\Resources\AllReminderRecource;
use App\Notifications\PushNotification;

class AllRemindersController extends Controller
{
    use Downloadable;
    public function listReminder(Request $request)
    {
        try {
            $search = '';
            $reletion = [];
            if (request()->has('search')) {
                if ($request->search == 'Appointment Reminder') {
                    $search = 'App\Models\AppointmentReminder';
                    $reletion = ['appointment_dates', 'appointment_times'];
                } elseif ($request->search == 'Medicine Reminder') {
                    $search = 'App\Models\MedicineReminder';
                    $reletion = ['time_schedule'];
                } else {
                    return api_success1('Record Not Found.');
                }
            }

            $reletion = ['time_schedule', 'appointment_dates', 'days'];

            $data = ReminderLogs::with([
                'reminderable' =>
                function ($s) use ($reletion) {
                    $s->with($reletion);
                }
            ])
                ->when(request()->filled('search'), function ($q) use ($search) {
                    $q->whereHasMorph('reminderable', $search);
                })
                ->where('reminderable_type', '!=', 'App\Models\DrinkingReminder')
                ->where('reminderable_type', '!=', 'App\Models\StretchReminder')
                ->where('reminderable_type', '!=', 'App\Models\JoggingReminder')
                ->where('user_id', auth()->user()->id)
                ->paginate(request('per_page') ?? 10);

            return api_successWithData('All Reminders', $data);
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function listOtherReminder(Request $request)
    {
        try {
            $search = '';
            if (request()->has('search')) {
                if ($request->search == 'Drinking Reminder') {
                    $search = 'App\Models\DrinkingReminder';
                } elseif ($request->search == 'Stretch Reminder') {
                    $search = 'App\Models\StretchReminder';
                } elseif ($request->search == 'Jogging Reminder') {
                    $search = 'App\Models\JoggingReminder';
                } else {
                    return api_success1('Record Not Found.');
                }
            }
            $data = ReminderLogs::with([
                'reminderable' =>
                function ($s) {
                    $s->with('days', function ($a) {
                        $a->select('jogging_id', 'days');
                    });
                }
            ])
                ->when(request()->filled('search'), function ($q) use ($search) {
                    $q->whereHasMorph('reminderable', $search);
                })
                ->where('reminderable_type', '!=', 'App\Models\MedicineReminder')
                ->where('reminderable_type', '!=', 'App\Models\AppointmentReminder')
                ->where('user_id', auth()->user()->id)
                ->paginate(request('per_page') ?? 10);

            return api_successWithData('All Reminders', $data);
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function markStatus(Request $request)
    {
        $check = ReminderLogs::where('id', $request->reminder_id)
            ->update(['snooze_status' => $request->snooze_status == true ? 1 : 0]);




        if ($check) {
            return api_success1('Status Updated Successfully');

            $check->notify(new PushNotification(
                'Mark medicine as taken',
                'User Id: ' . $check->id,
                [
                    'content_id' => $check->id

                ]
            ));
        }
        return api_success1('Reminder Not Found.');
    }

    public function deleteReminder(Request $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $data = ReminderLogs::where('id', $request->reminder_Id)->where('user_id', auth()->user()->id)->first();
            if (!empty($data)) {
                ($data->reminderable_type)::where('id', $data->reminderable_id)->first();
                ReminderLogs::where('id', $request->reminder_Id)->where('user_id', auth()->user()->id)->delete();
                return api_success1('Reminder Deleted Successfully');
            } else {
                return api_success1('Reminder Not Found!');
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function getReportDetails(Request $request)
    {

        $medicine = ReminderLogs::with('reminderable')
            ->whereHasMorph('reminderable', 'App\Models\MedicineReminder')
            ->where('user_id', auth()->user()->id)
            ->paginate('10');

        $appointments = ReminderLogs::with('reminderable')
            ->whereHasMorph('reminderable', 'App\Models\AppointmentReminder')
            ->where('user_id', auth()->user()->id)
            ->paginate('10');

        return response()->json(['appointments' => $appointments, 'medicine' => $medicine]);
    }

    public function downloadReport(Request $request)
    {

        $reletion = $request->type == 'medicine' ? 'App\Models\MedicineReminder' : 'App\Models\AppointmentReminder';

        $data = ReminderLogs::with('reminderable')
            ->whereHasMorph('reminderable', $reletion)
            ->where('user_id',  auth()->user()->id)
            ->get();

        if ($request->format == 'excel') {

            return $this->excelDownload($data, $request);
        } else {

            return $this->wordDownload($data, $request);
        }
    }

    public function statusReminder(Request $request)
    {
        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }
        try {
            $data = ReminderLogs::where('reminderable_id', $request->reminder_id)->where('user_id', auth()->user()->id)->first();

            if (!empty($data)) {
                $check = ($data->reminderable_type)::where('id', $request->reminder_id)->update(['status' => $request->status]);
                $data = ReminderLogs::where('reminderable_id', $request->reminder_id)->where('user_id', auth()->user()->id)->update(['status' => $request->status]);

                if ($check) {
                    return api_success1('Status Updated Successfully');
                }
            } else {
                return api_success1('Reminder Not Found!');
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }



    public function getDetails(Request $request)
    {
        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        $appointment = ['appointment_dates', 'appointment_times'];
        $jogging = ['days'];
        $medicine = ['time_schedule'];

        try {

            $search = '';
            if (request('type')) {
                if ($request->type == 'Appointment Reminder') {
                    $search = 'App\Models\AppointmentReminder';
                } elseif ($request->type == 'Medicine Reminder') {
                    $search = 'App\Models\MedicineReminder';
                } elseif ($request->type == 'Drinking Reminder') {
                    $search = 'App\Models\DrinkingReminder';
                } elseif ($request->type == 'Stretch Reminder') {
                    $search = 'App\Models\StretchReminder';
                } elseif ($request->type == 'Jogging Reminder') {
                    $search = 'App\Models\JoggingReminder';
                } else {
                    return api_success1('Record Not Found.');
                }
            }

            $data = ReminderLogs::where('reminderable_id', $request->reminder_Id)
                ->whereHasMorph('reminderable',  $search)
                ->where('user_id', auth()->user()->id)->first();
            // return $data;
            if (!empty($data)) {
                if ($data->reminderable_type == 'App\Models\MedicineReminder') {
                    $relation = $medicine;
                } elseif ($data->reminderable_type == 'App\Models\AppointmentReminder') {
                    $relation = $appointment;
                } elseif ($data->reminderable_type == 'App\Models\JoggingReminder') {
                    $relation = $jogging;
                }

                $check = ($data->reminderable_type)::with($relation)->where('id', $request->reminder_Id)->first();
                if ($check) {
                    return api_success1($check);
                }
            } else {
                return api_success1('Reminder Not Found!');
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }
}
