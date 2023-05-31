<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Fact;
use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserSmile;
use App\Models\BusinessLog;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use App\Models\ReminderLogs;
use App\Models\UserBusiness;
use App\Models\UserPackages;
use Illuminate\Http\Request;
use App\Models\UserDidYouKnow;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\User\LoginRequest;

class AdminController extends Controller
{
    
    public function __invoke()
    {
        return view('layouts.admin');
    }
    public function home(Request $request){
        $total_users = User::where('status',1)->where('user_type','!=','user')->count();
        $total_medicine_reminder= ReminderLogs::where('reminderable_type','App\Models\MedicineReminder')->count();
        $total_appointment_reminder= ReminderLogs::where('reminderable_type','App\Models\AppointmentReminder')->count();
        
        return response()->json(compact(
            'total_users',
            'total_medicine_reminder',
            'total_appointment_reminder',
        ));

        


        
    }

    public function adminDashboardStatic(Request $request){
        $year = request('year', date('Y'));
        $from = $year . '-01-01 00:00:00';
        $to = $year . '-12-31 00:00:00';
        $data = Transaction::selectRaw('MONTH(created_at) as month, SUM(amount) as count')
        ->whereBetween('created_at', [$from, $to])
        ->groupBy('month')
        ->get();
        $temp = [];
        $totalSum = 0;
        for ($i = 1; $i <= 12; $i++){
        $row = $data->where('month', $i)->first();
        $totalSum += (int)($row ? $row->count:0);
        $temp[] = $row? $row->count: 0;
        }
        return response()->json(['graphdata'=>$temp]);
        }

        public function adminDashboardSubscription(Request $request){
            $year = request('year', date('Y'));
            $from = $year . '-01-01 00:00:00';
            $to = $year . '-12-31 00:00:00';
            $data = UserPackages::selectRaw('MONTH(created_at) as month, COUNT(id) as count')
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('month')
            ->get();
            $temp = [];
            $totalSum = 0;
            for ($i = 1; $i <= 12; $i++){
            $row = $data->where('month', $i)->first();
            $totalSum += (int)($row ? $row->count:0);
            $temp[] = $row? $row->count: 0;
            }
            return response()->json(['graphdata'=>$temp]);
            }


    public function get_businesses(){
        $users = UserBusiness::whereNotNull('business_name')
        // ->whereNotIn('id',[request('exclude')])
        ->get();
        return response()->json(compact('users'));
    }


    public function login(LoginRequest $request)
    {

        $type = 'admin';
       
        try {
            // for login with both username and password
            // if ($request->exists('phone') && $request->filled('phone') && $request->filled('country_code')) {
            //     $credentials = request(['phone', 'password', 'country_code']);
            // } else {
            $credentials = request(['email', 'password']);
            // }

            if (!Auth::attempt($credentials)) {
                return api_error('Invalid credentials.');
            }
            $user = $request->user();
    
            if (!$user->status) {
                return api_error('Please verify your email address');
            }


            if (strtolower($user->user_type) != strtolower($type)) {
                return api_error('Invalid Account Type, Only admin users can login');
            }

            
            if ($user->status == 2) {
                return api_error('Your Account is Blocked/Deleted');
            }

            foreach ($user->tokens as $token) {
                $token->revoke();
            }

            $user->device_token = request('device_token');
            $user->device_type = request('device_type');
            $user->save();

            $tokenObj = $user->createToken('user access token');
            
            $token = $tokenObj->token;
            $token->device_token = request('device_token');
            $token->device_type = request('device_type');
            $token->expires_at = Carbon::now()->addWeeks(4);
            $token->save();

            $token->accessToken;
            $token = $tokenObj->accessToken;
            $user->makeHidden('tokens');

            $data = Arr::add($user->toArray(), 'token_detail', ['access_token' => $token, 'token_type' => 'Bearer',]);

            Artisan::call('schedule:run');
            // Artisan::call('schedule:work');

            return api_success('Login Successfully', $data);
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }
}
