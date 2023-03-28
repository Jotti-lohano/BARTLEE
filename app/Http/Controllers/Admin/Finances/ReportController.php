<?php

namespace App\Http\Controllers\Admin\Finances;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Order $order)
    {
        $reports = Order::addSelect(['report_amount' => DB::table('order_details as od')->selectRaw('price')
        ->whereColumn('od.order_id','orders.id')
        ->where('od.type','report')])
        ->where('type','report')
        ->withCount(['business_user as business_name' => function($q)
        {
              $q->select('business_name');
        }])
        ->when(request()->filled('search'), function($qry){
            $qry->whereHas('business_user', function($q){
                $q->where('business_name', 'like', '%'.request('search').'%');
            });                        
             })
            ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
                  $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
            })
        ->paginate(request('entries'));
        return response()->json(compact('reports'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       
        
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
        $reports = OrderDetail::where('type','report')
        ->when(request('duration') != 'all',function($q){
            $q->whereBetween('created_at',[
            now()->subDays( request('duration',1) )->startOfDay(),
            now()->endOfDay()
            ]);  
        })
        ->sum('price');
    
        return response()->json(compact('reports'));
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
