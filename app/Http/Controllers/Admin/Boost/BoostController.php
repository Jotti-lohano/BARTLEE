<?php

namespace App\Http\Controllers\Admin\Boost;

use App\Models\Boost;
use App\Models\Offer;
use App\Models\BusinessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class BoostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $boosts = Boost::select('id' ,'business_id' ,'type','status' ,'created_at' ,'clicks')
        ->addSelect(['business_username' => DB::table('users as user')
        ->selectRaw('username')
        ->whereColumn('user.id','boosts.business_id'),
        ])
        ->withCount(['business as business_name' => function($q)
          {
                $q->select('business_name');
          }])
       ->when(request()->filled('status'),function($q)
           {
             $q->where('status',request('status'));
           })
       ->when(request()->filled('search'), function($qry){
            $qry->whereHas('business_user', function($q){
                $q->where('username', 'like', '%'.request('search').'%');
            });                        
        })
       ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
               $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
       })
       ->paginate(request('entries'));
       return response()->json(compact('boosts'));
 
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $acive_boost = Boost::addSelect([
        'profile_visits' => BusinessLog::selectRaw('COUNT(*)')
        ->whereColumn('business_logs.boost_id','boosts.id'),
        'clicks_left' => \DB::raw('(SELECT (clicks - profile_visits) ) as clicks_left'), 
        ])->where( 'starting_date', '<=', date('Y-m-d') )->having('clicks_left', '>', 0)->count();

        $upcoming_boost = Boost::where( 'starting_date', '>', date('Y-m-d') )->count();

        $boosts_cards['active'] = $acive_boost ;
        $boosts_cards['upcomming'] = $upcoming_boost ;

        return response()->json(compact('boosts_cards'));
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

        $boost = Boost::with('transaction:id,amount,transitionable_id')->addSelect(
        ['business_username' => DB::table('users as user') ->selectRaw('username') ->whereColumn('user.id','boosts.business_id') ,
         'profile_visits' => BusinessLog::selectRaw('COUNT(*)')->whereColumn('business_logs.boost_id','boosts.id'),
         'clicks_left' => \DB::raw('(SELECT (clicks - profile_visits) ) as clicks_left')
         ])
        ->withCount(['business as business_name' => function($q)
          {
                $q->select('business_name');
          }])->where('id' , $id)
       ->first();

       return response()->json(compact('boost'));
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
