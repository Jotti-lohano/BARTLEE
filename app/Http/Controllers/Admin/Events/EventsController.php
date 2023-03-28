<?php

namespace App\Http\Controllers\Admin\Events;

use App\Models\User;
use App\Models\Event;
use App\Models\Country;
use App\Models\EventLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::select('id' ,'business_id' ,'event_name','event_ending_date as is_active' ,'created_at' , 'event_ending_date')
         ->when(request()->filled('search'),function($q){
            $q->where(function($q){
                $q->where('event_name','like','%'.request('search').'%');
            });
        })
        ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
            $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
        })
        ->withCount(['business as business_name' => function($q)
        {
            $q->select('business_name');
        },'saved_events as num_of_saved'])->paginate(request('entries'));
 
        return response()->json(compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $event = Event::withCount(['business as business_name' => function($q)
       {
           $q->select('business_name');
       }])->withCount(['business as business_user_id' => function($q)
       {
           $q->select('business_id');
       }])
       ->addSelect([
            'male_attended' => EventLog::selectRaw('COUNT(user_id)')
                    ->whereColumn('events.id','event_logs.event_id')
                    ->where('type','attended')
                    ->whereIn('event_logs.user_id',function($q){
                        $q->select('id')
                        ->from('users')
                        ->whereColumn('users.id','event_logs.user_id')
                        ->where('gender','male');
                    }),
            'female_attended' => EventLog::selectRaw('COUNT(user_id)')
                    ->whereColumn('events.id','event_logs.event_id')
                    ->where('type','attended')
                    ->whereIn('event_logs.user_id',function($q){
                        $q->select('id')
                        ->from('users')
                        ->whereColumn('users.id','event_logs.user_id')
                        ->where('gender','female');
                    }),
            'male_saved' => EventLog::selectRaw('COUNT(user_id)')
                    ->whereColumn('events.id','event_logs.event_id')
                    ->where('type','attended')
                    ->whereIn('event_logs.user_id',function($q){
                        $q->select('id')
                        ->from('users')
                        ->whereColumn('users.id','event_logs.user_id')
                        ->where('gender','male');
                    }),
            'female_saved' => EventLog::selectRaw('COUNT(user_id)')
                    ->whereColumn('events.id','event_logs.event_id')
                    ->where('type','attended')
                    ->whereIn('event_logs.user_id',function($q){
                        $q->select('id')
                        ->from('users')
                        ->whereColumn('users.id','event_logs.user_id')
                        ->where('gender','female');
                    }),
            'total_clicks' => EventLog::selectRaw('COUNT(*)')
                                    ->whereColumn('event_logs.event_id','events.id')
                                    ->orWhereColumn('event_logs.event_id','events.parent_id')
                                    ->where('type','click'),
            'total_saved' => EventLog::selectRaw('COUNT(*)')
                                    ->whereColumn('event_logs.event_id','events.id')
                                    ->orWhereColumn('event_logs.event_id','events.parent_id')
                                    ->where('type','saved'),
            'another_events_saved' => EventLog::selectRaw('COUNT(DISTINCT(user_id))')
                                    ->where('type','saved')
                                    ->whereIN('user_id',function($q){
                                        $q->select('user_id')
                                        ->from('event_logs')
                                        ->whereColumn('event_logs.event_id','!=','events.id')
                                        ->orWhereColumn('event_logs.event_id','!=','events.parent_id');
                                    }),
            'another_events_attended' => EventLog::selectRaw('COUNT(DISTINCT(user_id))')
                                    ->where('type','attended')
                                    ->whereIn('user_id',function($q){
                                        $q->select('user_id')
                                        ->from('event_logs')
                                        ->whereColumn('event_logs.event_id','!=','events.id')
                                        ->orWhereColumn('event_logs.event_id','!=','events.parent_id');
                                    }),
        ])
        ->withCount('saved_events','attended','clicks')
       ->where('id' , $id)->first();
        request()->merge([
            'event_id' => $id,
        ]);
        $attended_countries_logs = Country::addSelect([
            'id',
            'name',
            'users_count' => EventLog::selectRaw('COUNT(*)')
                    ->whereIn('user_id',function($q){
                        $q->select('id')
                        ->from('users')
                        ->whereColumn('users.country_id','countries.id');
                    })->where('event_logs.type','attended'),
        ])->whereIn('id',function($q){
            $q->select('country_id')
            ->from('users')
            ->whereIn('users.id',function($q){
                $q->select('user_id')
                ->from('event_logs')
                ->where('event_id',request('event_id'))
                ->where('type','attended');
            });
        })->get()->map(function($country,$index){
            $color = 'yellow';
            if($index % 2 === 0 ){
                $color = 'black';
            }
            return [$country->name,$country->users_count,$color];
        });
        $saved_countries_logs = Country::addSelect([
            'id',
            'name',
            'users_count' => EventLog::selectRaw('COUNT(*)')
                    ->whereIn('user_id',function($q){
                        $q->select('id')
                        ->from('users')
                        ->whereColumn('users.country_id','countries.id');
                    })->where('event_logs.type','saved'),
        ])->whereIn('id',function($q){
            $q->select('country_id')
            ->from('users')
            ->whereIn('users.id',function($q){
                $q->select('user_id')
                ->from('event_logs')
                ->where('event_id',request('event_id'))
                ->where('type','saved');
            });
        })->get()->map(function($country,$index){
            $color = 'yellow';
            if($index % 2 === 0 ){
                $color = 'black';
            }
            return [$country->name,$country->users_count,$color];
        });

        $event->attended_countries_logs = $attended_countries_logs;
        $event->saved_countries_logs = $saved_countries_logs;
        $saved_logs = \DB::select(
            'SELECT IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) <= 13),0) as below_13,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?) AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 13 AND 17),0)  as 13_17,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 18 AND 24 ),0)  as 18_24,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 25 AND 34  ),0) as 25_34,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 35 AND 44 ),0) as 35_44,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 55 AND 64 ),0) as 55_64,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) >= 65),0) as 65_plus'
        ,[
            $event->id,
            'saved',
            $event->id,
            'saved',
            $event->id,
            'saved',
            $event->id,
            'saved',
            $event->id,
            'saved',
            $event->id,
            'saved',
            $event->id,
            'saved'
        ])[0];
        $attended_age_logs = \DB::select(
        'SELECT IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) <= 13),0) as below_13,
        IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?) AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 13 AND 17),0)  as 13_17,
        IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 18 AND 24 ),0)  as 18_24,
        IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 25 AND 34  ),0) as 25_34,
        IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 35 AND 44 ),0) as 35_44,
        IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 55 AND 64 ),0) as 55_64,
        IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) >= 65),0) as 65_plus',
            [
            $event->id,
            'attended',
            $event->id,
            'attended',
            $event->id,
            'attended',
            $event->id,
            'attended',
            $event->id,
            'attended',
            $event->id,
            'attended',
            $event->id,
            'attended'
        ])[0];
        $i = 0;
        $filtered_logs = [];
        collect($saved_logs)->each(function($value,$key) use(&$i,&$filtered_logs){
            $color = 'yellow';
            if($i % 2 === 0 ){
                $color = 'black';
            }
            $title = str_replace(['_plus','below_','_'],['+','Below ','-'],$key);                
            $filtered_logs[] =  [$title,$value,$color];
        });
        $event->saved_age_logs = $filtered_logs;
        
        $filtered_logs = [];
        $i = 0;
        collect($attended_age_logs)->each(function($value,$key) use(&$i,&$filtered_logs){
            $color = 'yellow';
            if($i % 2 === 0 ){
                $color = 'black';
            }
            
            $title = str_replace(['_plus','below_','_'],['+','Below ','-'],$key);

            $filtered_logs[] =  [$title,$value,$color];
        });
        $event->attended_age_logs = $filtered_logs;
        
       $userInfo = User::find($event->business_user_id);

       if($userInfo) 
       {
            $event['username'] =$userInfo->username;
            $event['avatar_img'] =$userInfo->avatar_url;
       }
       else
       $event['username'] = $event['avatar_img'] ='';
       
        return response()->json(compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
