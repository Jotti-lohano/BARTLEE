<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\UserPackages;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {


        $log = UserPackages::with(["subscriber", "package"])
            ->whereHas('subscriber', function ($q) {
                $q->when(request()->filled('search'), function ($q) {
                    $q->where('first_name', 'like', '%' . request('search') . '%');
                    $q->orWhere('email', 'like', '%' . request('search') . '%');
                    $q->orWhere('last_name', 'like', '%' . request('search') . '%');
                });
            })
            ->orWhereHas('package', function ($q) {
                $q->when(request()->filled('search'), function ($q) {
                    $q->where('package_name', 'like', '%' . request('search') . '%');
                    $q->orwhere('package_amount', 'like', '%' . request('search') . '%');
                });
            })
            ->when(request()->filled('status'), function ($q) {
                $q->where('status', request('status'));
            })
            ->when(request()->filled('fromDate') && request()->filled('toDate'), function ($q) {
                $q->whereBetween('purchase_date', [request('fromDate'), request('toDate')]);
            })
            ->latest()
            ->paginate(request('entries'));


        // ->when(request()->filled('search'), function ($q) {
        //     $q->where(function ($q) {
        //         $q->where('firstname', 'like', '%' . request('search') . '%')
        //             ->orWhere('lastname', 'like', '%' . request('search') . '%')
        //             ->orWhere('email', 'like', '%' . request('search') . '%');
        //     });
        // })


        return response()->json(['status' => true, 'msg' => 'Logs', 'subscriptions' => $log]);
    }

    public function plan()
    {

        $plans = Package::all();
        return response()->json(['status' => true, 'plan' => $plans]);
    }
    public function planOne(Request $request)
    {
        $plans = Package::where('id', $request->id)->first();
        return response()->json(['status' => true, 'plan' => $plans]);
    }

    public function edit(Request $request, $id)
    {

        $user_status = Package::find($id);
        $user_status->package_name = $request->package_name;
        $user_status->package_amount = $request->package_amount;
        $user_status->save();
        return response()->json(['status' => true, 'msg' => 'Pacakge Update Successfully', 'data' => $user_status]);
    }

    public function store(Request $request)
    {

        $page = Package::create($request->all());
        return response()->json(['message' => 'Packgege Created Successfully', 'status' => true]);
    }
}
