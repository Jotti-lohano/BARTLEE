<?php

namespace App\Http\Controllers\Admin\Configuration;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PushAnnoucement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\PushNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Pagination\LengthAwarePaginator;

class PushAnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
      $notifications = DB::table('notifications')->when(request()->filled('search'),function($q)
       {
           $q->where(function($q){
               $q->where('data','like','%'.request('search').'%');
           });
       })
       ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q)
       {
           $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
 
       })
       ->where('notifier_type' , 'admin')
       ->paginate(request('entries'));  

       $pushAnnoucements  = $notifications->map(function($noti){
        $data['id'] = $noti->id;
        $jData = json_decode($noti->data);
        $data['title'] = $jData->title;
        $data['notifier_type'] = $noti->notifier_type;
        $data['created_at'] = $noti->created_at;
       
    
      
        return $data;
     });

     $pushAnnoucements = new LengthAwarePaginator($pushAnnoucements, $notifications->total(),$notifications->perPage());    

 
       return response()->json(compact('pushAnnoucements'));
        
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
      
        // dd($admin);

        $u = User::find(1);

        $title = "ABC";
        
        $body = '@ -Anees';

       
        
        $u->notify(new PushNotification(
        
        $title,
        
        $body
        
        ));


        // $pushAnnoucement = DB::table('notifications')->create(['data' => $data , 'notifier_type' => 'admin']);
        return  Response()->json(['status' =>true ,'msg' =>'Push Annoucement Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pushAnnoucement = PushAnnoucement::find($id);
        return response()->json(compact('pushAnnoucement'));
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
            $rider_img_path = $request->file('image')->storeAs('Admin/PushAnnouncements/Images', $file_name, 'public');
            $data['image'] =  $rider_img_path;
        }
        $pushAnnoucement = PushAnnoucement::where('id',$id)->update( $data );
        return  Response()->json(['status' =>true ,'msg' =>'Push Annoucement Updated Successfully']);
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
