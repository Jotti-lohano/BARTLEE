<?php

namespace App\Http\Controllers\Admin\AccountCategory;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AccountCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::addSelect(['num_of_business' => DB::table('users as user_b')->selectRaw('COUNT(id)')->whereColumn('user_b.category_id','categories.id')])
        ->when(request()->filled('search'),function($q){
           $q->where(function($q){
               $q->where('name','like','%'.request('search').'%');
           });
       })
       ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
           $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
 
       })
       ->when(request()->filled('status'),function($q)
       {
         $q->where('status',request('status'));
     })
     ->when(request()->filled('page'),function($q){

         return $q->paginate(request('entries'));
     },function($q){

        return $q->get();
    });
       
 
       return response()->json(compact('category'));
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
  
        $category = Category::create($request->all());
       
        return  Response()->json(['status' =>true ,'msg' =>'Category Added Successfully']);
    }

    public function fetchAccountCategory()
    {
        
        $account_categories =  Category::select('id','name' ,'status')->get();
        return response()->json(compact('account_categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return response()->json(compact('category'));
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
        $input = $request->only(['name' , 'color' ,'status']);
        $category = Category::where('id',$id)->update($input);
        return  Response()->json(['status' =>true ,'msg' =>'Category Updated Successfully']);
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
    public function updateStatus( Request $request)
    {
       $updateStatus = $request->status == 1 ? 0 : 1;
       $status = Category::where('id' , $request->id)->update(['status' => $updateStatus] );
       $record = Category::find($request->id);
       return $request->status !=  $record->status ? response()->json(['status' =>true ,'msg' =>'Category Status Updated Successfully'] ,200) :  response()->json(['status' =>false ,'msg' =>'Category Status Not Updated'] ,422);
    }
}
