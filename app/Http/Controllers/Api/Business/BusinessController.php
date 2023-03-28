<?php

namespace App\Http\Controllers\Api\Business;

use App\Http\Controllers\Controller;
use App\Models\BusinessType;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class BusinessController extends Controller
{

    public function getBusinessList(Request $request)
    {

        $list = BusinessType::select('id','business_type')->get();
        return response()->json(['status' => true, 'businessList' => $list]);
    }

    public function getArtists(Request $request)
    {
       $artists = UserProfile::with('UserArist.artist_profession','artist_skills','artist_work')->where('user_type','artist')->get();
       return response()->json(['status' => true, 'artistList' => $artists]);
    }
}
