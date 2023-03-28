<?php

namespace App\Http\Controllers\Admin;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicineType;

class MedicineController extends Controller
{
    public function index(Request $request){

        $medicine = MedicineType::when(request()->filled('type'),function($q){
            $q->where('status',request('type'));
        })
        ->when(request()->filled('search'),function($q){
            $q->where(function($q){
                $q->where('medicine_type','like','%'.request('search').'%')
                ->orWhere('volume','like','%'.request('search').'%');
            });
        })
        ->paginate(request('entries'));
        return response()->json(compact('medicine'));
    }

    public function store (Request $request){

        $data = new MedicineType();
        $data->medicine_type = $request->medicine_type;
        $data->volume =$request->medicine_volume;
        $data->save();
        return $data ?  response()->json(['status'=>true ,'msg'=>'Medicine Added Successfully']) :  response()->json(['status'=>false ,'msg'=>'Not Added']);
    }

    public function updateStatusMedicine(Request $request){
        $user_status = MedicineType::find($request->userId);
        if($request->status == 1){
            $user_status->status = 1;
            $user_status->save();
            return response()->json(['status'=>true,'msg'=>'Active Successfully','data' => $user_status]);
        }
        else{
            $user_status->status = 0;
            $user_status->save();
            return response()->json(['status'=>true,'msg'=>'In Active Successfully','data' => $user_status]);
        }
    }

    public function edit(Request $request,$id){
        $user_status = MedicineType::find($id);
            $user_status->medicine_type = $request->medicine_type;
            $user_status->volume = $request->volume;
            $user_status->save();
            return response()->json(['status'=>true,'msg'=>'Medicine Type Update Successfully','data' => $user_status]);
    }
}
