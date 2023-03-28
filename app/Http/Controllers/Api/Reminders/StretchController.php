<?php

namespace App\Http\Controllers\Api\Reminders;

use App\Models\Admin;
use App\Models\ReminderLogs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Notifications\AdminNotify;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Interfaces\StretchRepositoryInterface;

class StretchController extends Controller
{
    private StretchRepositoryInterface $stretchRepository;

    public function __construct(StretchRepositoryInterface $stretchRepository)
    {
        $this->stretchRepository = $stretchRepository;
    }

    public function setStretchReminder(Request $request): JsonResponse
    {
        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $reminderDetails = $request->only([
                'user_id', 'wakeup_time', 'sleepingHour', 'interval', 'reminderTime', 'reminder_with_alarm', 'user_id', 'status'
            ]);

            $admin_notify = Admin::where('id', 1)->first();
            Notification::send($admin_notify, new AdminNotify([
                'title' => 'New Stretch Reminder Added',
                'message' => 'User Id: ' . $request->id,
                'id' => $request->id,
                'route' => 'admin.users.show',

            ]));

            return api_success('Reminder Set Successfully', $this->stretchRepository->setReminder($reminderDetails));
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function updateStretchReminder(Request $request): JsonResponse
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $reminderId = $request->stretchingReminder_id;
            $newreminder = $request->only([
                'user_id', 'wakeup_time', 'sleepingHour', 'interval', 'reminderTime', 'reminder_with_alarm', 'user_id', 'status'
            ]);

            return api_success('Reminder Update Successfully', $this->stretchRepository->updateReminder($reminderId, $newreminder));
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function setStretchNotification()
    {
        $search = '';
        if (request()->has('type')) {
            if (request('type') == 'posture') {
                $search = 'App\Models\StretchReminder';
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
            return api_success('Stretch Notification Set Successfully', $getData);
        }
        return api_success1('Reminder Not Found.');
    }
}
