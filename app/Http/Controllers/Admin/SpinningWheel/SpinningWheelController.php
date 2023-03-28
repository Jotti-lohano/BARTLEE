<?php

namespace App\Http\Controllers\Admin\SpinningWheel;

use App\Http\Controllers\Controller;
use App\Models\SpinningWheel;
use App\Models\UserReward;
use Illuminate\Http\Request;

class SpinningWheelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $rewards = SpinningWheel::get();
       return response()->json(compact('rewards'));

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
       $reward = SpinningWheel::create($request->all());
       return response()->json(['status'=>true,'msg'=>'Reward Added Successfully'],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reward = SpinningWheel::find($id);
       return response()->json(compact('reward'));
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
        $reward = SpinningWheel::where('id' , $id)->update($request->all());
        return response()->json(['status'=>true,'msg'=>'Reward Updated Successfully'],200);
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

    public function spinCards(Request $request)
    {
        $spins = SpinningWheel::when(request('duration') != 'all',function($q){
            $q->whereHas('user_rewards', function($qr){
                $qr->whereBetween('created_at',[
                    now()->subDays( request('duration',1) )->startOfDay(),
                    now()->endOfDay()
                    ]);  
            }); 
        })
        ->whereHas('user_rewards', function($q){
            $q->where('reward_id', '!=' , null);
        })
        ->sum('reward');

        return response()->json(compact('spins'));
    }

    
}
