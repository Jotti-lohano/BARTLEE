<?php

namespace App\Http\Controllers\Api\Artist;

use Exception;
use App\Models\User;
use App\Models\Profession;
use App\Models\UserArtist;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Faker\Provider\UserAgent;

class ArtistController extends Controller
{
    //
    public function getProfessions(){
       try {
            $professions = Profession::select('id','Profession')->get();
                return api_success('Professions',$professions );
            }
        catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500 ) ;
        }
    }

     public function getWorks(Request $request)
    {
        # code...
 
        if (auth('api')->check()) {

            $user = UserProfile::where('user_id',Auth()->user()->id)->first();
           
          
            if ($user) {

                $artist = UserArtist::with('artist_work:id,user_artist_id,content')->where('user_profile_id',$user->id)->get();
                
                return api_success("Get Your Works", $artist);
                
            }else{
                return api_error('No Record Found');
            }
      
           
        }else{
            return api_error('PLease login first');
        }
    }

    public function uploadContent(Request $request)
    {
        # code...


        try{

            $user = UserProfile::where('user_id',auth()->user()->id)->first();
            $userArtist = UserArtist::where("user_profile_id",$user->id)->first();

            if($request->hasfile('upload_content')){

                foreach($request->file('upload_content') as $file){
                    $name = time().$file->getClientOriginalName();
                   
                    $file->move(public_path('artist_content'),$name);
                    $contentName = 'artist_content/'.$name;
                    $userArtist->artist_work()->create([
                        'content' =>$contentName,
                    
                    ]);
                }
                return api_success1('Content Added successfully' );
            }
            
        }catch(\Exception $ex){

            return api_error('message: ' . $ex->getMessage(), 500 ) ;
        }
    }

    public function editProfile(Request $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $dataMain = User::whereId(auth()->user()->id)->first();
            $dataMain->first_name = $request->first_name ? $request->first_name : $dataMain->first_name;
            $dataMain->last_name = $request->last_name ? $request->last_name : $dataMain->last_name;
            $dataMain->username = ($request->first_name ?  $request->first_name : $dataMain->first_name)  . '' . ($request->last_name ? $request->last_name : $dataMain->last_name);
            $dataMain->phone = $request->phone_number ? $request->phone_number :  $dataMain->phone;
            $dataMain->country_code = $request->country_code ? $request->country_code : $dataMain->country_code ;
            $dataMain->gender = $request->gender ? $request->gender : $dataMain->gender;
            $dataMain->location = $request->location ?  $request->location : $dataMain->location;
            if ($request->gender == 'Male' || $request->gender == 'male') {

                $avatar = 'male.png';
            } else {
                $avatar = 'female.png';
            }

            $dataMain->avatar = $avatar;

            if ($request->has('avatar')) {
                $fileName = time() . '_' . $request->avatar->getClientOriginalName();
                $filePathAvatar = $request->file('avatar')->storeAs('user/avatar', $fileName, 'public');
                $dataMain->avatar = $fileName;
            }

            $dataMain->save();

            $data = UserProfile::whereuserId(auth()->user()->id)->first();
           
            $data->first_name = $request->first_name ? $request->first_name : $dataMain->first_name;
            $data->last_name = $request->last_name ? $request->last_name : $dataMain->last_name;
            $data->name = ($request->first_name ?  $request->first_name : $dataMain->first_name)  . '' . ($request->last_name ? $request->last_name : $dataMain->last_name);
            $data->phone_number = $request->phone_number ?  $request->phone_number : $data->phone_number; 
            $data->country_code = $request->country_code ?  $request->country_code : $data->country_code; 
            $data->country = $request->country_id  ?  $request->country_id : $data->country;
            $data->city = $request->city_id  ?  $request->city_id : $data->city;       
            $data->gender = $request->gender  ?  $request->gender : $data->gender;
          
            $data->location = $request->location  ?  $request->location : $data->location ;
            $data->status = 1;

            if ($request->has('avatar')) {
                $fileName = time() . '_' . $request->avatar->getClientOriginalName();
                $filePathAvatar = $request->file('avatar')->storeAs('user/avatar', $fileName, 'public');
                $data->avatar = $fileName;
            }

            if ($data->save()) {

                $artist = UserArtist::where('user_profile_id',$data->id)->first();
         
                $artist->about_yourself = $request->about_yourself ? $request->about_yourself : $artist->about_yourself;
                $artist->years_of_experience = $request->years_of_experience ? $request->years_of_experience : $artist->years_of_experience;
                $artist->company_name = $request->company_name ? $request->company_name : $artist->company_name;
                $artist->save();
               
                
                return api_success("Profile updated successfully", $dataMain);
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }
}
