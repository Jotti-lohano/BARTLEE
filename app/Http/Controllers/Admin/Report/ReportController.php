<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Order $order){
        $reports = $order->with('items','business_user')
        ->where('type','report')
        ->when(request()->filled('search'),function($q){
            $q->whereIn('id',function($q){
                $q->select('order_id')
                ->from('order_details')
                ->where('name','like','%'.request('search').'%');
            });
        })
        ->paginate(request('entries'));
        return response()->json(compact('reports'));
    }
}
