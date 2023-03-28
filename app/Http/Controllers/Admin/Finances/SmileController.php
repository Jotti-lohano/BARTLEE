<?php

namespace App\Http\Controllers\Admin\Finances;

use App\Models\UserSmile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SmileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $smiles = UserSmile::where('type','in')
        ->addSelect([
                'name' => DB::table('users as users')->selectRaw('name')
                ->whereColumn('users.id','user_smiles.user_id'),
                ])
                    ->when(request()->filled('search'), function($qry){
            $qry->whereHas('user', function($q){
                $q->where('name', 'like', '%'.request('search').'%');
            });                        
        })
        ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
            $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
        })
        ->paginate(request('per_page',10));
        return response()->json(compact('smiles'));
        
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
        $smiles = UserSmile::selectRaw(DB::raw('SUM(amount) as total_amount'))->where('type','in')
        ->when(request('duration') != 'all',function($q){
            $q->whereBetween('created_at',[
            now()->subDays( request('duration',1) )->startOfDay(),
            now()->endOfDay()
            ]);  
        })
        ->first();
        return response()->json(compact('smiles'));
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
