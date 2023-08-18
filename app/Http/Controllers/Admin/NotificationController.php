<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function index(Request $request)
    { 
       
        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }
     

        $notifications = Notification::orderBy('created_at', 'DESC')->where('notifiable_id', auth('api')->user()->id)->where('read_at', null)->paginate(10);
        $success['notifications'] = $notifications;
        return $this->response->success(
        NotificationResource::collection($notifications) );
       
    }

    public function count()
    {
        $count = Notification::orderBy('created_at', 'DESC')->where('notifiable_id', auth('api')->user()->id)->where('read_at', null)->count();
        return response()->json(["notification_count" => $count]);
    }

    public function show(Request $request)
    {
        // $notifications = Notification::all();
        // $success['notifications'] = $notifications;
        // return response()->json($success);
    }

    public function getNotification()
    {
        $notifications = Notification::where('read_at', null)->orderBy('created_at', 'DESC')
            ->where('data->title', 'New user Registered')
            ->orwhere('data->title', 'New Subscription')
            ->get();

        $notifications_count = Notification::where('read_at', null)
            ->where('data->title', 'New user Registered')->orwhere('data->title', 'New Subscription')
            ->count();
        $success['notification_count'] = $notifications_count;
        $success['notifications'] = $notifications;
        return response()->json($success);
    }
    public function getAllNotification()
    {
        $notifications = Notification::orderBy('created_at', 'DESC')->get();
        $success['notifications'] = $notifications;
        return response()->json($success);
    }

    public function markAsRead(Request $request)
    {
        $markRead = Notification::where('notifiable_id', auth()->user()->id)->update(['read_at' => Carbon::now()->format('Y-m-d H:i:s')]);

        // $markRead = Notification::where('notifiable_id', auth()->user()->id)->first();
        // $markRead->read_at = Carbon::now()->format('Y-m-d H:i:s');
        // $markRead->save();
        return response()->json(['status' => true, 'notification' => $markRead, 'msg' => 'Mark as read successully']);
    }
}
