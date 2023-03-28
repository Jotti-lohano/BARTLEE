<?php

namespace App\Http\Controllers\Admin\Configuration;

use App\Models\Sticker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StickersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stickers = Sticker::addSelect(['num_of_business' => DB::table('user_stickers as user_b')->selectRaw('COUNT(id)')->whereColumn('user_b.sticker_id','stickers.id')])
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
       
       ->paginate(request('entries'));
 
       return response()->json(compact('stickers'));
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
        $data = $request->all();
        if($request->hasFile('image'))
        {
            $file_name = time() . '_' . $request->file('image')->getClientOriginalName();
            $rider_img_path = $request->file('image')->storeAs('Admin/Stickers/Images', $file_name, 'public');
            $data['image'] =  $rider_img_path;
        }
        $business_type = Sticker::create( $data );
        return  Response()->json(['status' =>true ,'msg' =>'Stickers Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sticker = Sticker::find($id);
        return response()->json(compact('sticker'));
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
        $data = $request->only(['name' , 'image' ,'status']);
        if($request->hasFile('image'))
        {
            $file_name = time() . '_' . $request->file('image')->getClientOriginalName();
            $rider_img_path = $request->file('image')->storeAs('Admin/Stickers/Images', $file_name, 'public');
            $data['image'] =  $rider_img_path;
        }
        $business_type = Sticker::where('id',$id)->update( $data );
        return  Response()->json(['status' =>true ,'msg' =>'Stickers Updated Successfully']);
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
       $status = Sticker::where('id' , $request->id)->update(['status' => $updateStatus] );
       $record = Sticker::find($request->id);
       return $request->status !=  $record->status ? response()->json(['status' =>true ,'msg' =>'Status Updated Successfully'] ,200) :  response()->json(['status' =>false ,'msg' =>'Status Not Updated'] ,422);
    }
}
