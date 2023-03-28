<?php

namespace App\Http\Controllers\Admin\Package;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\UserSmile;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Package $package,$type){
        
        $model = resolve('App\\Models\\'.ucfirst($type));
        ${$type} = $model->when(request()->filled('search') && $type == 'package',function($q){
            $q
            ->where('package_name','like','%'.request('search').'%')
            ->orWhere('package_amount','like','%'.request('search').'%')
            ->orWhere('no_of_smiles','like','%'.request('search').'%');

        })
        ->when(request()->filled('search') && $type == 'smile',function($q){
            $q
            ->where('number_of_smiles','like','%'.request('search').'%')
            ->orWhere('Amount','like','%'.request('search').'%');

        })
        ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
            $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
        })
        ->paginate(request('entries'));
        return response()->json(compact($type));
    }

    public function show($type,$id){
        
        $model = resolve('App\\Models\\'.ucfirst($type));
        ${$type} = $model
        ->where('id',$id)
        ->first();
        return response()->json(compact($type));
    }

    public function purchases($type){
        
        
        if($type == 'smiles'){
            ${$type} = UserSmile::with('user.business_user')->where('type','in')
            ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
                $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
            })
            ->paginate(request('per_page',10));
        }

        if($type == 'packages'){
            ${$type} = Order::with('business_user')->whereNotNull('package_id')
            
            ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
                $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
            })
            ->paginate(request('per_page'));
            
            
        }

        
        return response()->json(compact($type));
    }

    public function store($type,Request $request){
        $model = resolve('App\\Models\\'.ucfirst($type));
        $storedModel = $model->create(
            $request->all(
                $model->getFillable()
            )
        );

        return response()->json(['status' => true,'msg' => "{$type} created successfully"]);

    }
    public function update($type,$id,Request $request){
        $model = resolve('App\\Models\\'.ucfirst($type))->find($id);
        $storedModel = $model->update(
            $request->all(
                $model->getFillable()
            )
        );

        return response()->json(['status' => true,'msg' => "{$type} updated successfully"]);

    }
}
