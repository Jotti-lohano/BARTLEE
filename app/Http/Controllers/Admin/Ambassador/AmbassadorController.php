<?php

namespace App\Http\Controllers\Admin\Ambassador;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AmbassadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $ambassadors = User::select('id' ,'username','status' ,'city_id' ,'country_id' ,'created_at' , DB::raw("CONCAT(users.city_id,' ',users.country_id) as location"))
       ->when(request()->filled('search'),function($q){
          $q->where(function($q){
              $q->where('username','like','%'.request('search').'%');
          });
      })
      ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
          $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);

      })
      ->when(request()->filled('status'),function($q)
      {
        $q->where('status',request('status'));
    })
      ->addSelect(['num_of_business' => DB::table('users as user_b')->selectRaw('COUNT(id)')->whereColumn('user_b.ambassader_id','users.id')])
      ->where('is_ambassader' , 1)->paginate(request('entries'));

      return response()->json(compact('ambassadors'));
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
        $ambassador = User::addSelect(['business_name' => DB::table('user_businesses as user_business')->selectRaw('business_name')->whereColumn('user_business.business_id','users.id')])->where('id' , $id)->first();

      return response()->json(compact('ambassador'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ambassador_business_user = User::addSelect(['business_name' => DB::table('user_businesses as user_business')
        ->selectRaw('business_name')
        ->whereColumn('user_business.business_id','users.id')
        ,'category_name' => DB::table('categories as category')
        ->selectRaw('name')
        
        ->whereColumn('category.id','users.category_id')
        ])
        
        ->when(request()->filled('search'), function($qry){
            $qry->whereHas('business_user', function($q){
                $q->where('business_name', 'like', '%'.request('search').'%');
            });                        
        })
        ->where('ambassader_id' , 1)
        ->paginate(request('entries'));
        return response()->json(compact('ambassador_business_user'));
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
