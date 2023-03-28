<?php

namespace App\Http\Controllers\Admin\Finances;

use App\Models\Boost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class BoostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boosts = Boost::select('id' ,'business_id' ,'type','status' ,'created_at' ,'clicks')
        ->addSelect([
        'amount' => DB::table('transactions as transactions')->selectRaw('amount')
        ->whereColumn('transactions.transitionable_id','boosts.id')
        ->where('transactions.transitionable_type',get_class(Boost::first())),
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
            $qry->whereHas('business', function($q){
                $q->where('business_name', 'like', '%'.request('search').'%');
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
    public function create(Request $request)
    {

        $boosts = Transaction::when(request('duration') != 'all',function($q){
            $q->whereBetween('created_at',[
            now()->subDays( request('duration',1) )->startOfDay(),
            now()->endOfDay()
            ]);  
        })->sum('amount');
        
       
        return response()->json(compact('boosts'));
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
        $boosts = Transaction::when(request('duration') != 'all',function($q){
            $q->whereBetween('created_at',[
            now()->subDays( request('duration',1) )->startOfDay(),
            now()->endOfDay()
            ]);  
        })->sum('amount');
        
       
        return response()->json(compact('boosts'));
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
