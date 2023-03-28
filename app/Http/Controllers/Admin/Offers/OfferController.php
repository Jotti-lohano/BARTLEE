<?php

namespace App\Http\Controllers\Admin\Offers;

use App\Models\User;
use App\Models\Offer;
use App\Models\Country;
use App\Models\OfferLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::select('id' ,'business_id' ,'offer_name','status' ,'created_at')
        ->when(request()->filled('search'),function($q){
           $q->where(function($q){
               $q->where('offer_name','like','%'.request('search').'%');
           });
       })
       ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
           $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
       })->with('business')
       ->withCount(['business as business_name' => function($q)
       {
           $q->select('business_name');
       }])->paginate(request('entries'));

       return response()->json(compact('offers'));
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
        $offer = Offer::withCount(['business as business_name' => function($q)
       {
           $q->select('business_name');
       }])->withCount(['business as business_user_id' => function($q)
       {
           $q->select('business_id');
       }])
       ->addSelect([
        'male_redeems' => OfferLog::selectRaw('COUNT(user_id)')
                ->whereColumn('offers.id','offer_logs.offer_id')
                ->where('type','redeem')
                ->whereIn('offer_logs.user_id',function($q){
                    $q->select('id')
                    ->from('users')
                    ->whereColumn('users.id','offer_logs.user_id')
                    ->where('gender','male');
                }),
        'female_redeems' => OfferLog::selectRaw('COUNT(user_id)')
                ->whereColumn('offers.id','offer_logs.offer_id')
                ->where('type','redeem')
                ->whereIn('offer_logs.user_id',function($q){
                    $q->select('id')
                    ->from('users')
                    ->whereColumn('users.id','offer_logs.user_id')
                    ->where('gender','female');
                }),
    ])
       ->withCount([
            'logs as visited' => function($q){
                $q->where('type','visit');
            },
            'logs as collected_weekly' => function($q){
                $q->where('type','collect')
                ->whereDate('created_at','>=',now()->startOfWeek())
                ->whereDate('created_at','<=',now()->endOfWeek());
            },
            'logs as redeemed_weekly' => function($q){
                $q->where('type','redeem')
                ->whereDate('created_at','>=',now()->startOfWeek())
                ->whereDate('created_at','<=',now()->endOfWeek());
            },
            'logs as redeemed' => function($q){
                $q->where('type','redeem');
            },
            'logs as collected' => function($q){
                $q->where('type','collect');
            }
        ])
       ->where('id' , $id)->first();
       $userInfo = User::find($offer->business_user_id);
       if($userInfo) 
       {
            $offer['username'] =$userInfo->username;
            $offer['avatar_img'] =$userInfo->avatar_url;
       }
       else
       $offer['username'] = $offer['avatar_img'] ='';
       
       /* $offer = Offer::
            addSelect([
                'male_redeems' => OfferLog::selectRaw('COUNT(user_id)')
                        ->whereColumn('offers.id','offer_logs.offer_id')
                        ->where('type','redeem')
                        ->whereIn('offer_logs.user_id',function($q){
                            $q->select('id')
                            ->from('users')
                            ->whereColumn('users.id','offer_logs.user_id')
                            ->where('gender','male');
                        }),
                'female_redeems' => OfferLog::selectRaw('COUNT(user_id)')
                        ->whereColumn('offers.id','offer_logs.offer_id')
                        ->where('type','redeem')
                        ->whereIn('offer_logs.user_id',function($q){
                            $q->select('id')
                            ->from('users')
                            ->whereColumn('users.id','offer_logs.user_id')
                            ->where('gender','female');
                        }),
            ])
            ->withCount([
                'logs as visited' => function($q){
                    $q->where('type','visit');
                },
                'logs as collected_weekly' => function($q){
                    $q->where('type','collect')
                    ->whereDate('created_at','>=',now()->startOfWeek())
                    ->whereDate('created_at','<=',now()->endOfWeek());
                },
                'logs as redeemed_weekly' => function($q){
                    $q->where('type','redeem')
                    ->whereDate('created_at','>=',now()->startOfWeek())
                    ->whereDate('created_at','<=',now()->endOfWeek());
                },
                'logs as redeemed' => function($q){
                    $q->where('type','redeem');
                },
                'logs as collected' => function($q){
                    $q->where('type','collect');
                }
            ])
            ->find($id); */
            
            request()->merge([
                'offer_id' => $id,
            ]);
            $offer->redeemed_countries_logs = Country::addSelect([
                'id',
                'name',
                'users_count' => OfferLog::selectRaw('COUNT(*)')
                        ->whereIn('user_id',function($q){
                            $q->select('id')
                            ->from('users')
                            ->whereColumn('users.country_id','countries.id')
                            ->where('offer_logs.type','redeem');
                        }),
            ])->whereIn('id',function($q){
                $q->select('country_id')
                ->from('users')
                ->whereIn('users.id',function($q){
                    $q->select('user_id')
                    ->from('offer_logs')
                    ->where('offer_id',request('offer_id'))
                    ->where('type','redeem');
                });
            })->get()->map(function($country,$index){
                $color = 'yellow';
                if($index % 2 === 0 ){
                    $color = 'black';
                }
                return [$country->name,$country->users_count,$color];
            });

            $age_logs = \DB::select(
                'SELECT IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE type = "redeem")  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) <= 13),0) as below_13,
                IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE type = "redeem") AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 13 AND 17),0)  as 13_17,
                IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE type = "redeem")  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 18 AND 24 ),0)  as 18_24,
                IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE type = "redeem")  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 25 AND 34  ),0) as 25_34,
                IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE type = "redeem")  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 35 AND 44 ),0) as 35_44,
                IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE type = "redeem")  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 55 AND 64 ),0) as 55_64,
                IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE type = "redeem")  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) >= 65),0) as 65_plus'
            )[0];
            $filtered_logs = [];
            collect($age_logs)->each(function($value,$key) use(&$i,&$filtered_logs){
                $color = 'yellow';
                if($i % 2 === 0 ){
                    $color = 'black';
                }
                $title = str_replace(['_plus','below_','_'],['+','Below ','-'],$key);                
                $filtered_logs[] =  [$title,$value,$color];
                $i++;
            });
            $offer->redeem_age_logs = $filtered_logs;
            $offer->redeem_week_stats = $this->week_stats($offer); 

       return response()->json(compact('offer'));
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


    public function week_stats(Offer $offer,$operand = '='){
        $logs = \DB::select(
            'SELECT IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE offer_id = ? AND type = ? AND created_at BETWEEN ? AND ? ORDER BY id desc)),0) as Mon,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE offer_id = ? AND type = ? AND created_at BETWEEN ? AND ? ORDER BY id desc)),0) as Tue,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE offer_id = ? AND type = ? AND created_at BETWEEN ? AND ? ORDER BY id desc)),0) as Wed,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE offer_id = ? AND type = ? AND created_at BETWEEN ? AND ? ORDER BY id desc)),0) as Thu,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE offer_id = ? AND type = ? AND created_at BETWEEN ? AND ? ORDER BY id desc)),0) as Fri,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE offer_id = ? AND type = ? AND created_at BETWEEN ? AND ? ORDER BY id desc)),0) as Sat,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM offer_logs WHERE offer_id = ? AND type = ? AND created_at BETWEEN ? AND ? ORDER BY id desc)),0) as Sun
            '
        ,[
            $offer->id,
            'redeem',
            now()->startOfWeek()->startOfDay(),
            now()->startOfWeek()->endOfDay(),
            $offer->id,
            'redeem',
            now()->startOfWeek()->addDay(1)->startOfDay(),
            now()->startOfWeek()->addDay(1)->endOfDay(),
            $offer->id,
            'redeem',
            now()->startOfWeek()->addDay(2)->startOfDay(),
            now()->startOfWeek()->addDay(2)->endOfDay(),
            $offer->id,
            'redeem',
            now()->startOfWeek()->addDay(3)->startOfDay(),
            now()->startOfWeek()->addDay(3)->endOfDay(),
            $offer->id,
            'redeem',
            now()->startOfWeek()->addDay(4)->startOfDay(),
            now()->startOfWeek()->addDay(4)->endOfDay(),
            $offer->id,
            'redeem',
            now()->startOfWeek()->addDay(5)->startOfDay(),
            now()->startOfWeek()->addDay(5)->endOfDay(),
            $offer->id,
            'redeem',
            now()->endOfWeek()->startOfDay(),
            now()->endOfWeek()->endOfDay(),
        ])[0];
        $filtered_logs = [];
        collect($logs)->each(function($value,$key) use(&$i,&$filtered_logs){
            $color = 'yellow';
            if($i % 2 === 0 ){
                $color = 'black';
            }
            $title = str_replace(['_plus','below_','_'],['+','Below ','-'],$key);                
            $filtered_logs[] =  [$title,$value,$color];
            $i++;
        });
        return $filtered_logs;
    }
}
