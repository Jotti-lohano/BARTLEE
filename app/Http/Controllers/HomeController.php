<?php

namespace App\Http\Controllers;

use App\Models\UserArtist;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboardRecords()
    {
        # code...
        $business = UserProfile::where('user_type', 'business')->count();
        $artist = UserProfile::where('user_type', 'artist')->count();
        return response()->json([
            'status' => 200,
            'total_business_user' => $business,
            'total_artist_user' =>$artist,
        ],200);
    }
}
