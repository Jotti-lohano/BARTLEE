<?php

namespace App\Http\Controllers\Api\Business;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\BusinessType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Http\Controllers\MainApiController;
use App\Http\Resources\ArtistListingResource;
use App\Http\Resources\BusinessListingResource;
use App\Models\Skills;

class BusinessController extends Controller
{
  public function __construct() 
  {
      parent::__construct();
  }

    public function getBusinessList(Request $request)
    {

        $list = BusinessType::select('id','business_type','status')->take(10)->get();
        return response()->json(['status' => true, 'businessList' => $list]);
    }

    public function getSkillList(Request $request)
    {
      
      $list = Skills::select('id','skill','status')->take(10)->get();
      return response()->json(['status' => true, 'skillList' => $list]);
    }
     
    public function getArtists(Request $request)
    {
       $artists = UserProfile::with('UserArtist.artist_profession','UserArtist.artist_skills.skill:id,skill','UserArtist.artist_work:id,user_artist_id,content')->where('user_type','artist')
   
       ->when(request()->filled('from'), function($q) {
        $q->whereDate('created_at', '>=', request('from'))->whereDate('created_at', '<=', request('to'));
      })

      ->when(request()->filled('search'), function($q) {
        $q->where(function($q) {
            $q->where('first_name', 'like', '%'.request("search").'%')
            ->orWhere('email', 'like', '%'.request("search").'%');
           
        });
      })
       ->paginate(request('entries'));
       return $this->response->success(
        ArtistListingResource::collection($artists) );
       return $this->response->success(ArtistListingResource::collection($artists));
   
     

    }
    public function getBusiness(Request $request)
    {
        $user =  UserProfile::with('user_business_detail')->where('user_type','business')

          ->when(request()->filled('from'), function($q) {
            $q->whereDate('created_at', '>=', request('from'))->whereDate('created_at', '<=', request('to'));
          })
          ->when(request()->filled('search'), function($q) {
            $q->where(function($q) {
                $q->where('first_name', 'like', '%'.request("search").'%')
                ->orWhere('email', 'like', '%'.request("search").'%')
                ->orWhere('user_type', 'like', '%'.request("search").'%');
            });
          })

          ->paginate(request('entries'));
          return $this->response->success(
            BusinessListingResource::collection($user) );
    
    }

    public function getBusinessUser(Request $request)
    {
      
      $user =  UserProfile::with('user_business_detail')->where('user_type','business')->first();

          return $this->response->success(
            new DefaultResource($user)
        );
    }

    public function getArtistsUser(Request $request)
    {

// return UserProfile::with('UserArtist.artist_profession','UserArtist.artist_skills.skill:id,skill','UserArtist.artist_work:id,user_artist_id,content')->find(12);
      $artists = UserProfile::with('UserArtist.artist_profession','UserArtist.artist_skills.skill:id,skill','UserArtist.artist_work:id,user_artist_id,content')->where('user_type','artist')->find($request->id);
      return $this->response->success(
        new DefaultResource($artists)
    );
    }

    public function updateStatus(Request $request)
    {
  
      $user = UserProfile::find($request->id);
      if($user){
        $user->status = $request->status;
        $user->save();
        return response()->json([
          'status_code' => 200,
          'message'     => 'status updated successfully!',
          'status' => $request->status,
          
        ],200);
      }else{
        return response()->json([
          'status_code' => 404,    
        ],404);
      }
     
      
    }

    public function addBusiness(Request $request)
    {

      $bussiness = new BusinessType();
      $bussiness->business_type = $request->type;
      $bussiness->status = 'Active';
      $bussiness->save();
        if($bussiness){
          return response()->json([
              'status' => 200,
            ]);
        }
    }

    public function addSkill(Request $request)
    {
      $skill = new Skills();
      $skill->skill = $request->skill;
      $skill->status = 'Active';
      $skill->save();
        if($skill){
          return response()->json([
              'status' =>200,
            ]);
        }
    }

}
