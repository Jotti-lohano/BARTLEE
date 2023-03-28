<?php

namespace App\Http\Controllers\Admin\Users;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Offer;
use App\Models\EventLog;
use App\Models\OfferLog;
use App\Models\Challenge;
use App\Models\BusinessLog;
use Illuminate\Http\Request;
use App\Models\SpinningWheel;
use App\Models\UserChallenge;
use App\Http\Controllers\Controller;
use App\Models\AppointmentReminder;
use App\Models\Badge;
use App\Models\BusinessType;
use App\Models\Medicine;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::withCount('user_subscription')

            ->when(request()->filled('userSubscription'), function ($q) {
                $q->having('user_subscription_count', request('userSubscription'));
            })
            ->when(request()->filled('status'), function ($q) {
                $q->where('status', request('status'));
            })
            ->when(request()->filled('search'), function ($q) {
                $q->where(function ($q) {
                    $q->where('username', 'like', '%' . request('search') . '%')
                        ->orWhere('email', 'like', '%' . request('search') . '%');
                });
            })
            ->when(request()->filled('userType'), function ($q) {
                $q->where('user_type', request('userType'));
            })
            ->where('user_type', '!=', 'user')
            ->latest()
            ->paginate(request('entries'));
        return response()->json(compact('users'));
    }

    public function updateStatus(Request $request)
    {
        $user_status = User::find($request->userId);
        if ($request->status == 1) {
            $user_status->status = 1;
            $user_status->save();
            return response()->json(['status' => true, 'msg' => 'Active Successfully', 'data' => $user_status]);
        } else {
            $user_status->status = 0;
            $user_status->save();
            return response()->json(['status' => true, 'msg' => 'In Active Successfully', 'data' => $user_status]);
        }
    }

    public function userMedicine(Request $request, $id)
    {

        $medicine_list = Medicine::when(request()->filled('med_type'), function ($q) {
            $q->where('medicine_type', request('med_type'));
        })
            ->when(request()->filled('medSearch'), function ($q) {
                $q->where(function ($q) {
                    $q->where('medicine_name', 'like', '%' . request('medSearch') . '%')
                        ->orWhere('medicine_color', 'like', '%' . request('medSearch') . '%');
                });
            })

            ->where('created_by', $id)
            ->paginate(request('medEntries'));
        return response()->json(compact('medicine_list'));
    }


    public function viewMedicine(Request $request, $id)
    {
        $get_user_medicine = Medicine::with('med_creator')->where('id', $id)->first();
        return response()->json(compact('get_user_medicine'));
    }

    public function userAppointments(Request $request, $id)
    {
        $appointment_list = AppointmentReminder::
        when(request()->filled('appStatus'), function ($q) {
            $q->where('status', request('appStatus'));
        })
        ->when(request()->filled('appointmentSearch'), function ($q) {
                $q->where(function ($q) {
                    $q->where('appointment_title', 'like', '%' . request('appointmentSearch') . '%')
                        ->orWhere('doctor_name', 'like', '%' . request('appointmentSearch') . '%')
                        ->orWhere('category', 'like', '%' . request('appointmentSearch') . '%')
                        ->orWhere('hospital_name', 'like', '%' . request('appointmentSearch') . '%');
                });
        })
        ->when(request('appStartDate') && request('appEndDate') , function ($q) {
            $q->whereBetween('created_at', [request('appStartDate'),request('appEndDate')]);
        })
        ->where('user_id', $id)
        ->paginate(request('appEntries'));
        return response()->json(compact('appointment_list'));
    }
    
    public function userAppointmentsDetails(Request $request,$id)
    {
        $appointment_details = AppointmentReminder::with('appointment_dates')->where('id',$id)
            ->first();
        return response()->json(compact('appointment_details'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('user_profile')->withCount('user_subscription')
            // ->when(request('type') == 'business',function($q){
            //     $q->with(['business_user' => function($q){
            //         $q->with(
            //             'packages',
            //             'media',
            //             'schedule',
            //             'badge_media',
            //             'groups.badges.badge_media',
            //             'groups.media',
            //             'facts'
            //         )
            //         // total_visits 
            //         ->withCount(['logs as total_visits' => function($q){
            //             $q->where('type','visit')
            //             // total_visits filter 
            //             ->when(request('visitor_duration') != 'all',function($q){
            //                 $q->whereBetween('created_at',[
            //                     now()->subDays( request('visitor_duration',1) )->startOfDay(),
            //                     now()->endOfDay() 
            //                 ]);
            //             });
            //         }]);
            //     }]);
            // })
            // ->withCount('followers','followings')
            ->find($id);


        // if(request('type') == 'business'){
        //     $media ='';
        //     if($user->business_user != '')
        //     {
        //         $media = collect($user->business_user->media)->filter(function($item){
        //             if($item['data']['type'] == 'images'){
        //                     return $item;
        //             }
        //         });
        //         $user->images = $media;
        //         $media = collect($user->business_user->media)->filter(function($item){
        //             if($item['data']['type'] == 'menu'){
        //                     return $item;
        //             }
        //         });
        //     }

        //     return response()->json(compact('user'));

        //     $user->menus = $media;
        //     $user->top_visitors = User::addSelect([
        //     'visits' => BusinessLog::selectRaw('COUNT(*)')
        //                 ->whereColumn('business_logs.user_id','users.id')
        //                 ->where('type','visit')
        //                 ->where('business_id',$user->business_user->id)
        //                 ])->whereIn('id',function($q) use($user) {
        //                     $q
        //                     ->select('user_id')
        //                     ->from('business_logs')
        //                     ->where('type','visit')
        //                     ->where('business_id',$user->business_user->id);
        //     })->latest('visits')->take(4)->get();
        //     // $user->business_user->logs()->where('type','visit')

        // }
        /* $user->challenges = $user->challenges()
        ->addSelect([
            '*',
            \DB::raw('(SELECT COUNT(*) from challenge_businesses WHERE challenge_businesses.challenge_id = challenges.id) as total_businesses_involved'), 
            \DB::raw('(SELECT total_businesses_involved * challenge_visits) as total_visits_required'),
            'total_visited_spots' => UserChallenge::selectRaw('COUNT(distinct user_id)')
            ->whereColumn('challenges.id','user_challenges.challenge_id'),
        ])
        ->where('is_completed',1)
        ->get(); */
        // $user->challenges = $user->user_challenges()->get();
        return response()->json(compact('user'));
    }

    public function offers(Request $request, $id)
    {
        return Offer::with('business.business_type')
            ->addSelect([
                'redeemed_on' => OfferLog::select('created_at')
                    ->whereColumn('offers.id', 'offer_logs.offer_id'),
            ])
            ->whereIn('id', function ($q) use ($id) {
                $q->select('offer_id')
                    ->from('offer_logs')
                    ->where('user_id', $id)
                    ->where('type', 'redeem');
            })

            ->paginate(3);
        // return response()->json(compact('offers'));
    }

    public function events(Request $request, $id)
    {
        return Event::with('business.business_type', 'business.badge_media')
            ->whereIn('id', function ($q) use ($id) {
                $q->select('event_id')
                    ->from('event_logs')
                    ->where('user_id', $id)
                    ->where('type', request('type'));
            })

            ->paginate(3);
        // return response()->json(compact('offers'));
    }

    public function challenges_stats(Request $request, $id)
    {

        return Challenge::with('business.badge_media')
            ->withCount(['users as my_visits_count' => function ($q) use ($id) {
                $q->where('user_id', $id);
            }])->addSelect([
                \DB::raw('IFNULL((SELECT COUNT(*) from challenge_businesses WHERE challenge_businesses.challenge_id = challenges.id),0) as total_businesses_involved'),
                \DB::raw('(SELECT total_businesses_involved * challenge_visits) as total_visits_required'),
                'total_visited_spots' => UserChallenge::selectRaw('COUNT(distinct user_id)')
                    ->whereColumn('challenges.id', 'user_challenges.challenge_id'),
            ])
            ->whereIn('id', function ($q) use ($id) {
                $q->select('challenge_id')
                    ->from('user_challenges')
                    ->where('user_id', $id);
            })
            ->when(request('type') == 'started', function ($q) {
                $q->havingRaw('my_visits_count < total_visits_required');
            }, function ($q) {
                $q->havingRaw('my_visits_count >= total_visits_required');
            })
            ->paginate(request('entries', 3));
    }

    public function badges(Request $request, $id)
    {
        $user = User::find($id);
        $badges = $user->user_badges()->with('badge.badge_media', 'badge.city', 'badge.country')->paginate(4);
        $badges_count = $user->user_badges()
            ->when(request('duration') != 'all', function ($q) {
                $q->whereBetween('created_at', [
                    now()->subDays(request('duration', 1))->startOfDay(),
                    now()->endOfDay()
                ]);
            })
            ->count();
        return response()->json(compact('badges', 'badges_count'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function fetchUserCardsGraph(Request $request)
    {


        // $user= User::select('created_at')->first();
        // $start = Carbon::parse($user->created_at);
        // $now = Carbon::now();
        // $days = $start->diffInDays($now);
        // $month = $start->diffInMonths($now);
        // $users['avgUserDay'] = $total_users / $days;
        // $users['avgUserMonthly'] = $total_users / $month;
        $date = Carbon::now()->subDays(14);

        $totalUser =  User::where('user_type', 'user')->count();
        $lastWeeklyUsers =  User::where('user_type', 'user')->where('created_at', '>=', $date)->count();
        $allUser = User::where('user_type', 'user')
            ->when(request('duration') != 'all', function ($q) {
                $q->whereBetween('created_at', [
                    now()->subDays(request('duration', 1))->startOfDay(),
                    now()->endOfDay()
                ]);
            })
            ->count();

        $totalBusiness =  User::where('user_type', 'business')->count();
        $lastWeeklyBusiness =  User::where('user_type', 'business')->where('created_at', '>=', $date)->count();
        $allBusiness = User::where('user_type', 'user')
            ->when(request('duration') != 'all', function ($q) {
                $q->whereBetween('created_at', [
                    now()->subDays(request('duration', 1))->startOfDay(),
                    now()->endOfDay()
                ]);
            })
            ->count();
        $totalBadges =  Badge::count();

        $data['card']['totalUser'] = $totalUser;
        $data['user']['lastTwoWeeks'] = $lastWeeklyUsers;
        $data['user']['avgUsers'] = $allUser;

        $data['card']['totalBusiness'] = $totalBusiness;
        $data['business']['lastTwoWeeks'] = $lastWeeklyBusiness;
        $data['business']['avgUsers'] = $allBusiness;

        $data['card']['totalBadges'] = $totalBadges;

        return response()->json(compact('data'));
    }

    public function fetchBusinessTypes(Request $request)
    {
        $business_type =  BusinessType::select('id', 'name', 'status')->get();

        return response()->json(compact('business_type'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
