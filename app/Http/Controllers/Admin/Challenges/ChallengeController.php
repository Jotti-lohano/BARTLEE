<?php

namespace App\Http\Controllers\Admin\Challenges;

use App\Models\Country;
use App\Models\Challenge;
use App\Models\UserBusiness;
use Illuminate\Http\Request;
use App\Models\UserChallenge;
use App\Http\Controllers\Controller;
use App\Core\Traits\ChallengeStatable;

class ChallengeController extends Controller
{
    use ChallengeStatable;
    public function index(Challenge $challenge){
        $data = $challenge
        ->with('business')
        ->when(request()->filled('status') && request('status') == 'past',function($q){
            $q->whereDate('challenge_ending_date','<',now());
        })
        ->when(request()->filled('type') && request('type') == 'challenges',function($q){
            $q->where('is_completed' ,1 );
        },function($q){
            $q->where('is_completed' ,0 )
            ->where('challenge_type','complex')
            ->whereDate('challenge_ending_date','>',now());
        })
        ->when(request()->filled('status') && request('status') == 'active',function($q){
            $q->whereDate('challenge_ending_date','>=',now())->where('status','active');
        })
        ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
            $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
        })
        ->when(request()->filled('search'),function($q){
            $q->where('challenge_name','like','%'.request('search').'%');
        })
        ->paginate(request('entries'));
        return response()->json(compact('data'));
    }

    public function update(Request $request,$id){
        $challenge = Challenge::find($id);
        if(strtolower($challenge->status) == 'active'){
            $challenge->status = 'inactive';
        }else{
            $challenge->status = 'active';
        }

        $challenge->save();
        return response()->json(['status' => true,'msg' => 'status updated successfully','data' => $challenge]);
    }


    public function store(Request $request,Challenge $challenge)
    {
        $user = UserBusiness::find($request->business_id);
        if($request->challenge_type == 'simple'){
            $request->merge([
                'is_completed' => 1,
                'status' => 'active',
                'businessess' => $user
            ]);
        }else{
            $request->merge([
                'is_completed' => 1,
                'status' => 'active',
                'businessess' => [$user->id] + $request->businessess
            ]);
        }
        $challenges = $user->challenges()->find($request->challenge_id);
        if(!$challenges){
            $user->challenges()->create($request->all(
                $challenge->getFillable()
            ));
        }else{
            $challenges->update($request->all(
                $challenge->getFillable()
            ));
        }

        $message = 'Challenge has been created successfully';

        return response()->json([
            'message' => $message,
            'status' => true,
        ]);
    }

    public function show($id, Request $request){
        $data = Challenge::addSelect([
            '*',
            \DB::raw('(SELECT COUNT(*) from challenge_businesses WHERE challenge_businesses.challenge_id = challenges.id) as total_businesses_involved'), 
            \DB::raw('IFNULL((SELECT total_businesses_involved * challenge_visits),0) as total_visits_required'),
            'total_visited_spots' => UserChallenge::selectRaw('COUNT(distinct user_id)')
            ->whereColumn('challenges.id','user_challenges.challenge_id'),
            'current_week_visits' => UserChallenge::selectRaw('COUNT(user_id)')
            ->whereColumn('challenges.id','user_challenges.challenge_id')
            ->whereDate('created_at','>=',now()->startOfWeek())
            ->whereDate('created_at','<=',now()->endOfWeek()),
            \DB::raw('(SELECT FLOOR(IFNULL(current_week_visits / total_visits_required,0)) ) as total_week_winners'),
        ])
        ->with(['business' => function($q){
            $q->with(['user' => function($q){
                $q->withCount('followings','followers');
            }]);
        }])->find($id);
        request()->merge([
            'challenge_id' => $data->id,
        ]);
        $started_countries_logs = Country::addSelect([
            'id',
            'name',
            'users_count' => UserChallenge::selectRaw('COUNT(DISTINCT user_id)')
                    ->whereIn('user_id',function($q){
                        $q->select('id')
                        ->from('users')
                        ->whereColumn('users.country_id','countries.id')
                        ;
                    })->where('challenge_id',$data->id),
        ])->whereIn('id',function($q)use($data){
            $q->select('country_id')
            ->from('users')
            ->whereIn('users.id',function($q)use($data){
                $q->select('user_id')
                ->from('user_challenges')
                ->where('challenge_id',request('challenge_id'))
                ->groupBy('user_id')
                ->havingRaw('COUNT(user_id) < ?',[$data->total_visits_required]);
            });
        })->get()->map(function($country,$index){
            $color = 'yellow';
            if($index % 2 === 0 ){
                $color = 'black';
            }
            return [$country->name,$country->users_count,$color];
        });
        $data->started_countries_logs = $started_countries_logs;
        
        $completed_countries_logs = Country::addSelect([
            'id',
            'name',
            'users_count' => UserChallenge::selectRaw('COUNT(DISTINCT user_id)')
                    ->whereIn('user_id',function($q){
                        $q->select('id')
                        ->from('users')
                        ->whereColumn('users.country_id','countries.id')
                        ;
                    })->where('challenge_id',$data->id),
        ])->whereIn('id',function($q)use($data){
            $q->select('country_id')
            ->from('users')
            ->whereIn('users.id',function($q)use($data){
                $q->select('user_id')
                ->from('user_challenges')
                ->where('challenge_id',request('challenge_id'))
                ->groupBy('user_id')
                ->havingRaw('COUNT(user_id) = ?',[$data->total_visits_required]);
            });
        })->get()->map(function($country,$index){
            $color = 'yellow';
            if($index % 2 === 0 ){
                $color = 'black';
            }
            return [$country->name,$country->users_count,$color];
        });
        $data->completed_countries_logs = $completed_countries_logs;
        // stats for weekly completions  
        $data->week_stats = $this->challenge_week_stats($data,'=');
        // stats for gender
        $data->gender_started = $this->challenge_gender_stats($data,'<');
        
        // stats for completed 
        $data->gender_completed = $this->challenge_gender_stats($data,'=');
        // stats age wise for started users
        $data->started_age_logs = $this->challenge_age_stats($data,'<');            
        // stats age wise for completed users
        $data->completed_age_logs = $this->challenge_age_stats($data,'=');
        return response()->json(compact('data'));
    }

    public function stats($id,$type){
        try {
            $data = Challenge::addSelect([
                '*',
                \DB::raw('(SELECT COUNT(*) from challenge_businesses WHERE challenge_businesses.challenge_id = challenges.id) as total_businesses_involved'), 
                \DB::raw('(SELECT total_businesses_involved * challenge_visits) as total_visits_required'),
                'total_visited_spots' => UserChallenge::selectRaw('COUNT(distinct user_id)')
                ->whereColumn('challenges.id','user_challenges.challenge_id'),
                'current_week_visits' => UserChallenge::selectRaw('COUNT(user_id)')
                ->whereColumn('challenges.id','user_challenges.challenge_id')
                ->whereDate('created_at','>=',now()->startOfWeek())
                ->whereDate('created_at','<=',now()->endOfWeek()),
                \DB::raw('(SELECT FLOOR(IFNULL(current_week_visits / total_visits_required,0)) ) as total_week_winners'),
            ])->find($id);
            request()->merge([
                'challenge_id' => $data->id,
            ]);
            $started_countries_logs = Country::addSelect([
                'id',
                'name',
                'users_count' => UserChallenge::selectRaw('COUNT(DISTINCT user_id)')
                        ->whereIn('user_id',function($q){
                            $q->select('id')
                            ->from('users')
                            ->whereColumn('users.country_id','countries.id')
                            ;
                        })->where('challenge_id',$data->id),
            ])->whereIn('id',function($q)use($data){
                $q->select('country_id')
                ->from('users')
                ->whereIn('users.id',function($q)use($data){
                    $q->select('user_id')
                    ->from('user_challenges')
                    ->where('challenge_id',request('challenge_id'))
                    ->groupBy('user_id')
                    ->havingRaw('COUNT(user_id) < ?',[$data->total_visits_required]);
                });
            })->get()->map(function($country,$index){
                $color = 'yellow';
                if($index % 2 === 0 ){
                    $color = 'black';
                }
                return [$country->name,$country->users_count,$color];
            });
            $data->started_countries_logs = $started_countries_logs;
            
            $completed_countries_logs = Country::addSelect([
                'id',
                'name',
                'users_count' => UserChallenge::selectRaw('COUNT(DISTINCT user_id)')
                        ->whereIn('user_id',function($q){
                            $q->select('id')
                            ->from('users')
                            ->whereColumn('users.country_id','countries.id')
                            ;
                        })->where('challenge_id',$data->id),
            ])->whereIn('id',function($q)use($data){
                $q->select('country_id')
                ->from('users')
                ->whereIn('users.id',function($q)use($data){
                    $q->select('user_id')
                    ->from('user_challenges')
                    ->where('challenge_id',request('challenge_id'))
                    ->groupBy('user_id')
                    ->havingRaw('COUNT(user_id) = ?',[$data->total_visits_required]);
                });
            })->get()->map(function($country,$index){
                $color = 'yellow';
                if($index % 2 === 0 ){
                    $color = 'black';
                }
                return [$country->name,$country->users_count,$color];
            });
            $data->completed_countries_logs = $completed_countries_logs;
            // stats for weekly completions  
            $data->week_stats = $this->challenge_week_stats($data,'=');
            // stats for gender
            $data->gender_started = $this->challenge_gender_stats($data,'<');
            
            // stats for completed 
            $data->gender_completed = $this->challenge_gender_stats($data,'=');
            // stats age wise for started users
            $data->started_age_logs = $this->challenge_age_stats($data,'<');            
            // stats age wise for completed users
            $data->completed_age_logs = $this->challenge_age_stats($data,'=');
                    
        } catch (\Exception $e) {
            return response()->json(['message' => 'something went wrong' ,'meta'=> $e->getMessage(),'status'=> false],500);
        }
        return response()->json(compact('challenge'));
    }
}
