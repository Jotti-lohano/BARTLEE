<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request){
        
        $pages = Page::when(request()->filled('search'),function($q){
            $q->where('name','like','%'.request('search').'%');
        })
        ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
            $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
        })
        ->latest('id')
        ->paginate(request('entries'));
        return response()->json(compact('pages'));
    }

    public function store(Request $request){
        
        $page = Page::create($request->all());
        return response()->json(['message' => 'page created successfully','status' => true]);
    }

    public function update($id,Request $request){
        
        $page = Page::find($id)->update($request->all());
        return response()->json(['message' => 'page updated successfully','status' => true]);
    }

    public function show($id){
        
        $page = Page::find($id);
        return response()->json(compact('page'));
    }
}
