<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessLog;
use App\Models\Fact;
use App\Models\ReminderLogs;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserBusiness;
use App\Models\UserDidYouKnow;
use App\Models\UserPackages;
use App\Models\UserSmile;
use Illuminate\Http\Request;

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
        // $total_users_filtered = User::where('user_type','user')
        //     ->when(request('total_users_duration') != 'all',function($q){
        //         $q->whereBetween('created_at',[
        //             now()->subDays( request('total_users_duration',1) )->startOfDay(),
        //             now()->endOfDay() 
        //         ]);
        //     })
        //     ->count();
        // $total_businesses = User::where('user_type','business')->count();
        // $total_businesses_filtered = User::where('user_type','business')
        // ->when(request()->filled('business_type'),function($q){
        //     $q->where('business_type_id',request('business_type'));
        //     // ->where();
        // })
        // ->when(request('total_businesses_duration') != 'all',function($q){
        //     $q->whereBetween('created_at',[
        //         now()->subDays( request('total_businesses_duration',1) )->startOfDay(),
        //         now()->endOfDay() 
        //     ]);
        // })
        // ->count();
        // $total_badges = UserBusiness::has('badge_media','>',0)->count();
        // $private_badges = UserBadge::where('is_public',0)->count();
        // $badges_collected = UserBadge::count();
        
        // $user_smiles_avg = UserSmile::whereIn('user_id',function($q){
        //     $q->select('id')
        //     ->from('users')
        //     ->where('user_type','user');
        // })
        // ->where('type','in')
        // ->groupBy('user_id')->avg('value')??0;

        // $business_smiles_avg = UserSmile::whereIn('user_id',function($q){
        //     $q->select('id')
        //     ->from('users')
        //     ->where('user_type','business');
        // })
        // ->where('type','in')
        // ->groupBy('user_id')->avg('value')??0;

        // $total_smiles = UserSmile::where('type','in')->sum('value')??0;
        // $collected_facts = UserDidYouKnow::when(request('facts_duration') != 'all',function($q){
        //     $q->whereBetween('created_at',[
        //         now()->subDays( request('facts_duration',1) )->startOfDay(),
        //         now()->endOfDay() 
        //     ]);
        // })->count();
        // $total_facts = Fact::when(request('total_facts_duration') != 'all',function($q){
        //     $q->whereBetween('created_at',[
        //         now()->subDays( request('total_facts_duration',1) )->startOfDay(),
        //         now()->endOfDay() 
        //     ]);
        // })->count();
        // $trending_places = UserBusiness::with([
        //     'badge_media',
        //     'city',
        //     'country'
        // ])
        // ->addSelect([
        //     'total_visits' => BusinessLog::selectRaw('COUNT(*)')
        //     ->whereColumn('business_logs.business_id','user_businesses.id')
        // ])->whereIn('id',function($q){
        //     $q->select('business_id')
        //     ->from('business_logs')
        //     ->whereColumn('business_logs.business_id','user_businesses.id')
        //     ->where('type','visit')
        //     ->when(request('trending_duration') != 'all',function($q){
        //         $q->whereBetween('created_at',[
        //             now()->subDays( request('trending_duration',1) )->startOfDay(),
        //             now()->endOfDay() 
        //         ]);
        //     });
        // })
        // ->when(request()->filled('trending_category'),function($q){
        //     $q->whereIn('business_id',function($q){
        //         $q->select('id')
        //         ->from('users')
        //         ->where('category_id',request('trending_category'));
        //     });
        // })
        // ->take(4)
        // ->latest('total_visits')
        // ->get();
        // $businesses = User::where('user_type','business')->latest('id')->take(5)->get();
        return response()->json(compact(
            'total_users',
            'total_medicine_reminder',
            'total_appointment_reminder',
            // 'total_businesses',
            // 'total_badges',
            // 'user_smiles_avg',
            // 'business_smiles_avg',
            // 'total_smiles',
            // 'collected_facts',
            // 'total_facts',
            // 'businesses',
            // 'badges_collected',
            // 'trending_places',
            // 'total_businesses_filtered',
            // 'total_users_filtered'
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
}
