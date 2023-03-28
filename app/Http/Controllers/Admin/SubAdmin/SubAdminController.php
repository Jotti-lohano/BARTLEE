<?php

namespace App\Http\Controllers\Admin\SubAdmin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class SubAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
       $admins = Admin::where('is_admin_type' ,0)
       ->when(request()->filled('search'),function($q){
          $q->where(function($q){
              $q->where('name','like','%'.request('search').'%');
          });
      })
      ->where('is_admin_type' ,0)
      ->when(request()->filled('status'),function($q){
          $q->where('status',request('status'));
      })
      ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
        $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
    })
      ->paginate(request('entries'));
      return response()->json(compact('admins'));
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
        $admin = Admin::create($request->all());
        return $admin ?  response()->json(['status'=>true ,'msg'=>'Sub Admin Added Successfully']) :  response()->json(['status'=>false ,'msg'=>'Sub Admin Not Added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $admin = Admin::find($id);
       return response()->json(compact('admin'));
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
        
        $admin = Admin::where('id' ,$id)->update($request->all());
        return $admin ?  response()->json(['status'=>true ,'msg'=>'Sub Admin Updated Successfully']) :  response()->json(['status'=>false ,'msg'=>'Sub Admin Not Updated']);
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
