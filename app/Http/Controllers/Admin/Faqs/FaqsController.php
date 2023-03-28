<?php

namespace App\Http\Controllers\Admin\Faqs;

use App\Models\FAQ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;

class FaqsController extends Controller
{
    public function index()
    {
        $faqs = ContactUs::when(request()->filled('search'), function ($q) {
                $q->where(function ($q) {
                    $q->where('firstname', 'like', '%' . request('search') . '%')
                        ->orWhere('lastname', 'like', '%' . request('search') . '%')
                        ->orWhere('email', 'like', '%' . request('search') . '%');
                });
            })
            ->when(request()->filled('fromDate') && request()->filled('toDate'), function ($q) {
                $q->whereBetween('created_at', [request('fromDate'), request('toDate')]);
            })
            ->latest()
            ->paginate(request('entries'));
        return response()->json(compact('faqs'));
    }

    public function show(Request $request, $id)
    {
        $faqs = ContactUs::where('id', $id)->first();
        return response()->json(compact('faqs'));
    }
}
