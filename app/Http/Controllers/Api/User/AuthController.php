<?php

namespace App\Http\Controllers\Api\User;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Admin;
use App\Models\Badge;
use App\Models\Sticker;
use App\Models\Category;
use App\Models\Follower;
use App\Models\ContactUs;
use App\Models\UserBadge;
use App\Models\UserGroup;
use App\Models\StoreToken;
use App\Models\UserArtist;
use App\Models\UserProfile;
use Illuminate\Support\Arr;
use App\Models\BusinessType;
use App\Models\UserBusiness;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\BusinessSticker;
use App\Models\business_details;
use App\Notifications\AdminNotify;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\changePassword;
use App\Notifications\PushNotification;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\SignupRequest;
use App\Http\Requests\User\SendOtpRequest;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\User\CreateBadgeRequest;
use App\Http\Requests\User\EditProfileRequest;
use App\Http\Requests\User\VerifyTokenRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\User\CheckUsernameRequest;
use App\Http\Requests\User\CreateProfileRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\ResendVerifyTokenRequest;
use App\Http\Requests\User\UpdateProfileInfoRequest;

class AuthController extends Controller
{
    public function signup(Request $request)
    {        
        // $data = User::find(10);
        // $mailInfo = [
        //     'user' => $data,
        //     'mail_for' => 'email_verification'
        // ];

        // $jj = api_send_mail($mailInfo);

        // dd('zzzz asdasd', $jj);

   
        try {

            $data = new User;
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->username = $request->first_name . '' . $request->last_name;
            $data->email = $request->email;
            $data->password = bcrypt($request->password);
            $data->phone = $request->phone ?? '0';
            $data->country_code = $request->country_code ?? '0';
            $data->status = 0;
            $data->device_token = request('device_token');
            $data->device_type = request('device_type');

            if ($request->has('avatar')) {
                $fileName = time() . '_' . $request->avatar->getClientOriginalName();
                $filePathAvatar = $request->file('avatar')->storeAs('user/avatar', $fileName, 'public');
                $data->avatar = $fileName;
            }

            $data->save();


            $check = UserProfile::where('user_id', $data->id)->first();
            if ($check) {
                $profileCheck = true;
            } else {
                $profileCheck = false;
            }

            $mailInfo = [
                'user' => $data,
                'mail_for' => 'email_verification'
            ];

            $jj = api_send_mail($mailInfo);


            return api_success('User created successfully!', ['user' => $data]);
        } catch (\Exception $e) {
            return api_error('Message: ' . $e->getMessage(), 500);
        }
    }

    public function userDelete(Request $request)
    {
        try {

            if (!auth('api')->check()) {
                return api_error('Message: Login required');
            }
    
            $user = auth()->user();

            if ($user) {
                
                if ($user->user_type ==  "artist") {
             
                
                 UserProfile::with(['UserArtist.artist_profession','UserArtist.artist_skills.skill:id,skill', 'UserArtist.artist_work:id,user_artist_id,content'])->where('user_id',auth('api')->user()->id)->delete();
                   
                  // $user['profile_complete'] = true;
                   
                }
                else {
                 
                 UserProfile::with('User','user_business_detail')->where('user_id',auth('api')->user()->id)->delete();
                  
                    $user->delete();
                }
                $data = api_success1('account deleted');
                return response()->json($data, Response::HTTP_OK);
            } 
            // if ($data) {
            //     $data->status = 2;
            //     $data->save();
            //     $data->delete();
            //     $profile = UserProfile::where('user_id', auth()->user()->id)->delete();
            //     $data = api_success1('account deleted');
            //     return response()->json($data, Response::HTTP_OK);
            // }
        } catch (\Exception $e) {
            $data = api_error($e->getMessage());
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
    }

    public function sendOtp(SendOtpRequest $request)
    {
        $data = User::whereEmail($request->email)->first();
        if (empty($data)) {
            return api_error("Email does not exists."); //
        }
        $mailInfo = [
            'user' => $data,
            'mail_for' => 'email_verification'
        ];
        api_send_mail($mailInfo);
        return api_success1('Otp sent successfully.');
    }

    public function verifyOtp(VerifyTokenRequest $request)
    {
        // check if email exists
        $data = User::whereEmail($request->email)->first();
        if (empty($data)) {
            return api_error("Email does not exists."); //
        }

        if ($result = StoreToken::where('verification_source', $request->email)->where('token', $request->otp)->first()) {

            // check if code is not expires
            if (Carbon::now() > $result->expires_at) {
                return api_error("Otp expired."); //
            }
            StoreToken::where('verification_source', $request->email)->delete();

            // update user status to active
            $data->status = 1;
            $data->save();

            return api_success1("Otp is valid");
        } else {
            return api_error("Invalid code!");
        }
    }

    public function verifySignup(Request $request)
    {
        // check if email exists
        $data = User::whereEmail($request->email)->first();
        if (empty($data)) {
            return api_error("Email does not exists."); //
        }

        if ($result = StoreToken::where('verification_source', $request->email)->where('token', $request->code)->first()) {

            // check if code is not expires
            if (Carbon::now() > $result->expires_at) {
                return api_error("Code expired."); //
            }
            StoreToken::where('verification_source', $request->email)->delete();

            // update user status to active
            $data->status = 1;
            $data->save();

            return api_success1("Code is valid");
        } else {
            return api_error("Invalid code!");
        }
    }

    public function resendVerificationCode(ResendVerifyTokenRequest $request)
    {
        $data = User::whereEmail($request->email)->whereNull('deleted_at')->first();

        if (!empty($data)) {

            $mailInfo = [
                'user' => $data,
                'mail_for' => 'email_verification'
            ];

            api_send_mail($mailInfo);
            return api_success1('Verification code sent successfullys.');
        } else {
            return api_error('Invalid email address.');
        }
    }

    public function login(LoginRequest $request)
    {

        
      
        try {
            // for login with both username and password
            // if ($request->exists('phone') && $request->filled('phone') && $request->filled('country_code')) {
            //     $credentials = request(['phone', 'password', 'country_code']);
            // } else {
            $credentials = request(['email', 'password']);
            // }

            if (!Auth::attempt($credentials)) {
                return api_error('Invalid credentials.');
            }
            $user = $request->user();
    
            if (!$user->status) {
                return api_error('Please verify your email address');
            }

            if ($user->status == 2) {
                return api_error('Your Account is Blocked/Deleted');
            }

            foreach ($user->tokens as $token) {
                $token->revoke();
            }

            $user->device_token = request('device_token');
            $user->device_type = request('device_type');
            $user->save();

            $tokenObj = $user->createToken('user access token');
            
            $token = $tokenObj->token;
            $token->device_token = request('device_token');
            $token->device_type = request('device_type');
            $token->expires_at = Carbon::now()->addWeeks(4);
            $token->save();

            $token->accessToken;
            $token = $tokenObj->accessToken;
            $user->makeHidden('tokens');

            $data = Arr::add($user->toArray(), 'token_detail', ['access_token' => $token, 'token_type' => 'Bearer',]);

            Artisan::call('schedule:run');
            // Artisan::call('schedule:work');

            return api_success('Login Successfully', $data);
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {

        $data = User::whereEmail($request->email)->whereNull('deleted_at')->first();
        if (!empty($data)) {
            $mailInfo = [
                'user' => $data,
                'mail_for' => 'forgot_password'
            ];
            api_send_mail($mailInfo); // Note: Credential required
            $get_token = StoreToken::where('verification_source',  $data->email)->first();
            return api_success('Verification code sent successfully.', $get_token->token);
        } else {
            return api_error('Email does not exists.');
        }
    }


    public function verifyToken(Request $request)
    {
        // return $request->email;
        $data = User::where('email', $request->email)
            // ->where('code', $request->code)
            ->first();
        // return $data;
        if (!empty($data)) {
            $verify = StoreToken::where('verification_source', $data->email)->where('token', $request->code)->first();
            if (!empty($verify)) {
                return api_success1('User Verified.');
            } else {
                return api_error('Invalid Code.');
            }
        } else {
            return api_error('Invalid Email.');
        }
    }

    public function  resetPassword(ResetPasswordRequest $request)
    {
        $verify = StoreToken::where('token', $request->code)->first();
        if (!empty($verify)) {
            $data = User::whereEmail($verify->verification_source)->first();
            if (!empty($data)) {
                $data->password = bcrypt($request->password);
                $data->save();
                StoreToken::where('verification_source', $data->email)->delete();
                return api_success1("Password changed successfully!");
            } else {
                return api_error("Invalid Code.");
            }
        } else {
            return api_error("Invalid Code.");
        }
    }


    public function createBusinsessProfile(CreateProfileRequest $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $checkUser = UserProfile::whereUserId(auth()->user()->id)->first();
            $user = User::whereId(auth()->user()->id)->first();
            if ($checkUser) {
                return api_error('Profile Already Created.');
            } else {

                if ($request->gender == 'Male' || $request->gender == 'male') {

                    $avatar = 'male.png';
                } else {
                    $avatar = 'female.png';
                }

                $dataMain = User::whereId(auth()->user()->id)->first();
                $dataMain->first_name =  $request->first_name ? $request->first_name : $dataMain->first_name;
                $dataMain->last_name = $request->last_name ?? $user->last_name;
               
                $dataMain->username = $request->first_name . '' . $request->last_name;
                $dataMain->phone = $request->phone_number ?? $user->phone_number;
                $dataMain->country_code = $request->country_code ?? $user->country_code;
                $dataMain->user_type = 'business';
                $dataMain->avatar =  $avatar;
                $dataMain->save();

                $data = new UserProfile();
                $data->user_id = auth()->user()->id;
                $data->first_name = $request->first_name ?? $user->first_name;
                $data->last_name = $request->last_name ?? $user->last_name;
                $dataMain->name = $request->first_name . '' . $request->last_name;
                $data->user_type = 'business';
                $data->phone_number = $request->phone_number ?? $user->phone_number;
                $data->email = $dataMain->email;
                $data->gender = $request->gender ?? $user->gender;
                $data->location = $request->location ?? $user->location;
                $data->country_code = $request->country_code ?? $user->country_code;
                $data->avatar = $avatar;
                $data->status = 1;

               



                $dataMain->notify(new PushNotification(
                    'User Has Been Registered As business',
                    'User Id: ' . $dataMain->id,
                    [
                        'content_id' => $dataMain->id

                    ]
                ));


                if ($request->has('avatar')) {
                    $fileName = time() . '_' . $request->avatar->getClientOriginalName();
                    $filePathAvatar = $request->file('avatar')->storeAs('user/avatar', $fileName, 'public');
                    $data->avatar = $fileName;
                }


                if ($data->save()) {

                    $businessData = new business_details();
                    $businessData->user_profile_id = $data->id;
                    $businessData->company_name = $request->company_name;
                    $businessData->business_type = $request->business_type;
                    $businessData->about_company = $request->about_company;

                    if ($request->has('companycreatePatientProfile_avatar')) {
                        $fileName = time() . '_' . $request->company_avatar->getClientOriginalName();
                        $filePathAvatar = $request->file('company_avatar')->storeAs('user/avatar', $fileName, 'public');
                        $businessData->avatar = $fileName;
                    }
               
                    $businessData->save();

                    $admin_notify = Admin::where('id', 1)->first();
                    Notification::send($admin_notify, new AdminNotify([
                        'title' => 'New user Registered',
                        'message' => 'User Id: ' . $data->id,
                        'id' => $data->id,
                        'route' => 'admin.users.index',

                    ]));
                   $userData = User::with('user_profile.user_business_detail')->where('id',auth()->user()->id)->first(); 
                    return api_success('Profile Created successfully',$userData );
                }

            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500 ) ;
        }
    }

    public function createArtistProfile(CreateProfileRequest $request)
    {

        
        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $checkUser = UserProfile::whereUserId(auth()->user()->id)->first();
            $user = User::whereId(auth()->user()->id)->first();
            if ($checkUser) {
                return api_error('Profile Already Created.');
            } else {

                if ($request->gender == 'Male' || $request->gender == 'male') {

                    $avatar = 'male.png';
                } else {
                    $avatar = 'female.png';
                }

                $dataMain = User::whereId(auth()->user()->id)->first();
                $dataMain->first_name =  $request->first_name ? $request->first_name : $dataMain->first_name;
                $dataMain->last_name = $request->last_name ?? $user->last_name;
                $dataMain->username = $request->first_name . '' . $request->last_name;
                $dataMain->phone = $request->phone_number ?? $user->phone_number;
                $dataMain->country_code = $request->country_code ?? $user->country_code;
                $dataMain->user_type = 'artist';
                $dataMain->avatar =  $avatar;
                $dataMain->save();

                $data = new UserProfile();
                $data->user_id = auth()->user()->id;
                $data->first_name = $request->first_name ?? $user->first_name;
                $data->last_name = $request->last_name ?? $user->last_name;
                $dataMain->name = $request->first_name . '' . $request->last_name;
                $data->user_type = 'artist';
                $data->phone_number = $request->phone_number ?? $user->phone_number;
                $data->email = $dataMain->email;
                $data->gender = $request->gender ?? $user->gender;
                $data->country_code = $request->country_code ?? $user->country_code;
                $data->avatar = $avatar;
                $data->status = 1;

               



                $dataMain->notify(new PushNotification(
                    'User Has Been Registered As business',
                    'User Id: ' . $dataMain->id,
                    [
                        'content_id' => $dataMain->id

                    ]
                ));


                if ($request->has('avatar')) {
                    $fileName = time() . '_' . $request->avatar->getClientOriginalName();
                    $filePathAvatar = $request->file('avatar')->storeAs('user/avatar', $fileName, 'public');
                    $data->avatar = $fileName;
                }


             

               



                if ($data->save()) {

                    $UserArtist = new UserArtist();
                    $UserArtist->user_profile_id = $data->id;
                    $UserArtist->about_yourself = $request->about_yourself;
                    $UserArtist->years_of_experience = $request->years_of_experience;
                    $UserArtist->company_name = $request->company_name;
                    $UserArtist->artist_profession = $request->artist_profession;
                    $UserArtist->is_featured = $request->is_featured;

                    if ($request->has('artist_avatar')) {
                        $fileName = time() . '_' . $request->artist_avatar->getClientOriginalName();
                        $filePathAvatar = $request->file('artist_avatar')->storeAs('user/avatar', $fileName, 'public');
                        $UserArtist->profile_picture = $fileName;
                    }
               
                    $UserArtist->save();

                    if($request->skills){

                        foreach($request->skills as $skill){
                            
                        
                            $UserArtist->artist_skills()->create([
                                'skill_id' => $skill,
                            ]);
                        }
                    }


                    if($request->hasfile('upload_content')){

                        foreach($request->file('upload_content') as $file){
                            $name = time().$file->getClientOriginalName();
                            $file->move(public_path('artist_content'),$name);
                            $contentName = 'artist_content/'.$name;
                            $UserArtist->artist_work()->create([
                                'content' =>$contentName,
                               
                            ]);
                        }
                    }

              



                    $admin_notify = Admin::where('id', 1)->first();
                    Notification::send($admin_notify, new AdminNotify([
                        'title' => 'New user Registered',
                        'message' => 'User Id: ' . $data->id,
                        'id' => $data->id,
                        'route' => 'admin.users.index',

                    ]));
    
                   $userData = User::with('user_profile.UserArtist')->where('id',auth()->user()->id)->first(); 
                    return api_success('Profile Created successfully',$userData );
                }

            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500 ) ;
        }
    }

    public function getProfile()
    {
        
     
        if (auth('api')->check()) {
            // dd(auth('api')->user()->id);
            $user = UserProfile::where('user_id', auth('api')->user()->id)->first();
        
            if ($user) {
                $user['profile_complete'] = true;
                if ($user->user_type ==  "artist") {
                
                  $user = UserProfile::with(['UserArtist.artist_profession','UserArtist.artist_skills.skill:id,skill', 'UserArtist.artist_work:id,user_artist_id,content'])->where('user_id',auth('api')->user()->id)->first();
                    // $user['profile_complete'] = true;
                }
                else {
                  
                    $user = UserProfile::with('user_business_detail')->where('user_id',auth('api')->user()->id)->first();
                }
            } 


            return api_success("Get profile info", $user);
        } else {

            return api_error('PLease login first');
        }
    }

    public function editProfile(Request $request)
    { 

    
        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {
           
            $dataMain = User::whereId(auth('api')->user()->id)->first();
         
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

          
            if ($request->avatar_url) {
                
                $fileName = time() . '_' . $request->avatar_url->getClientOriginalName();
               
                //$filePathAvatar = $request->file('avatar_url')->storeAs('user/avatar', $fileName, 'public');
                $request->avatar_url->move(public_path('storage/user/avatar'), $fileName); 
                $dataMain->avatar = $fileName;

                
            }

            if ($request->has('avatar')) {
                
                $fileName = time() . '_' . $request->avatar->getClientOriginalName();
                $filePathAvatar = $request->file('avatar')->storeAs('storage/user/avatar', $fileName, 'public');
                
                $dataMain->avatar = $fileName;
            }

            $dataMain->save();
           

            $data = UserProfile::whereuserId(auth('api')->user()->id)->first();
           
            $data->first_name = $request->first_name  ? $request->first_name : $data->first_name;;
            $data->last_name = $request->last_name ? $request->last_name : $data->last_name; 
            $data->phone_number = $request->phone_number  ? $request->phone_number :  $data->phone;;
            $data->country_code = $request->country_code ? $request->country_code : $data->country_code ;;
       
            $data->gender = $request->gender;
          
            $data->location = $request->location;
            $data->status = 1;

            if ($request->has('avatar')) {
                $fileName = time() . '_' . $request->avatar->getClientOriginalName();
              
                $request->avatar_url->move(public_path('storage/user/avatar'), $fileName); 
                $data->avatar = $fileName;
            }

               
            if ($request->avatar_url) {
               
                $fileName = time() . '_' . $request->avatar_url->getClientOriginalName();
                
               // $filePathAvatar = $request->file('avatar_url')->storeAs('storage/user/avatar', $fileName, 'public');
              // $request->avatar_url->move(public_path('storage/user/avatar'), $fileName); 
                $data->avatar = $fileName;
            }
           
            if ($data->save()) {
                return api_success("Profile updated successfully", $dataMain);
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function logout()
    {

        if (auth('api')->check()) {
            $user = auth('api')->user();
            $user->token()->revoke();
            return api_success1("Logout successfully!");
        } else {
            return api_error('PLease login first');
        }

        return api_error('Unable to logout');
    }

    public function contactUs(Request $request)
    {

        $input = $request->all();
        if ($input) {
            ContactUs::create($input);
            $success['message'] = "Thank you for contacting us!";
        } else {
            $success['message'] = "Error";
        }
        return response()->json([$success]);
    }

    public function privacyPolicy()
    {
        $policy = DB::table('privacy_policy')->where('for_featured_artist',0)->first();
        return response()->json($policy);
    }

    public function termsCondition()
    {
        $terms = DB::table('terms_condition')->where('for_featured_artist',0)->first();
        return response()->json($terms);
    }

    public function privacyPolicyForArtist()
    {
        $policy = DB::table('privacy_policy')->where('for_featured_artist',1)->first();
        return response()->json($policy);
    }

    public function termsConditionForArtist()
    {
        $terms = DB::table('terms_condition')->where('for_featured_artist',1)->first();
        return response()->json($terms);
    }

    public function changePassword(changePassword $request)
    {
      
        if (Hash::check($request->current_password, auth('api')->user()->password)) {
            $user = auth('api')->user();
        
            // if($request->new_password ==  $request->confirm_new_password){
              
            $user->password =  bcrypt($request->new_password);
            $user->save();
            return $this->sendResponse($user, __('Password has been updated successfully'));
            // }else{
            //     return $this->sendError(__('Password and ConfirmPassword Does Not Matched'), false);
            // }
        }
        return $this->sendError(__('current password in not valid'), false);
    }

    // get user badges
    public function getUserBadges()
    {
        $badges = [];
        $user = auth('api')->user();
        $data = $user->load('user_badges.badge.badge');

        foreach ($data->user_badges as $badge) {

            $bu = User::find($badge->badge->business_id);

            $badgeData['badge_id'] = $badge->badge->id;
            $badgeData['city'] = $bu->city ? $bu->city->name : '';
            //		$badgeData['badge_image'] = $badge->badge->media ? $badge->badge->media[0]->path : '';
            $badgeData['name'] = $badge->badge->business_name;


            /*           unset($badge->badge->business_id);
            unset($badge->badge->created_at);
            unset($badge->badge->updated_at);
*/
            if (request()->filled('badge_id') && request()->badge_id == $badge->badge->id) {
                $badges[] = $badgeData; //->badge;
            } elseif (!request()->filled('badge_id')) {
                $badges[] = $badgeData; //->badge;
            }
        }

        if (count($badges)) {
            return api_success('Badges', $badges);
        } else {
            return api_success('Badges not found.', []);
        }
    }

    public function addUserGroup(Request $request)
    {
        $image = null;
        if ($request->has('image')) {
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $filePathimage = $request->file('image')->storeAs('user/group', $fileName, 'public');
            $image = asset("storage/user/group/{$fileName}", false);
        }

        $user_group = UserGroup::create([
            'user_id' => auth('api')->user()->id,
            'name' => $request->name,
            'image' => $image,
        ]);

        $user_group->group_badges()->attach($request->badge_ids);
        return api_success1('Added successfully');
    }

    public function editUserGroup(Request $request, UserGroup $userGroup)
    {
        if ($request->has('image')) {
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $filePathimage = $request->file('image')->storeAs('user/group', $fileName, 'public');
            $userGroup->image = asset("storage/user/group/{$fileName}", false);
        }

        $userGroup->name = $request->name ? $request->name : $userGroup->name;

        $userGroup->save();

        $userGroup->group_badges()->sync($request->badge_ids);
        return api_success1('Updated successfully');
    }

    // get user groups
    public function getUserGroups()
    {
        $groups = [];
        $user = auth('api')->user();
        $data = $user->load('user_groups.group_badges');

        return api_success('Groups', $data);

        /* foreach ($data->user_groups as $group) {
            unset($group->user_id);
            unset($group->badge_id);
            unset($group->created_at);
            unset($group->updated_at);

            if (request()->filled('group_id') && request()->group_id == $group->id) {
                $groups[] = $group;
            } elseif (!request()->filled('group_id')) {
                $groups[] = $group;
            }
        }
        if (count($groups)) {
            return api_success('Groups', $groups);
        } else {
            return api_error('Groups not found.');
        }*/
    }

    // get user cities
    public function getUserCities()
    {
        $cities = [];
        $user = auth('api')->user();
        $user = $user->load('user_badges.badge.user.city');

        if (!count($user->user_badges)) {
            return api_success('Cities', []);
        }

        foreach ($user->user_badges as $ub) {
            $cities[] = $ub->badge->user->city;
        }


        return api_success('Cities', $cities);
    }

    public function getUserBadgesByCityId(Request $request)
    {
        $city_id = $request->city_id;

        $cities = [];
        $user = auth('api')->user();
        $user = $user->load('user_badges.badge.city');

        foreach ($user->user_badges as $ub) {
            $badge_ids[] =  $ub->badge_id;
        }

        $badges =  Badge::whereIn('id', $badge_ids)->where('city_id', $city_id)->get();

        /* foreach($badges as $badge){
            $ci[] =  $badge->city_id;
        }

        $cities = City::whereIn('id',$ci)->where('id',$city_id)->get();*/

        return api_success('Badges', $badges);
    }

    public function profileInterest()
    {
        $user = auth('api')->user();
        $data = $user->load('user_business_types.business_type.business_type', 'user_stickers.sticker');
        return api_success('Profile Interest', $data);
    }

    public function UserProfileInterest(User $user)
    {
        $data = $user->load('user_business_types.business_type.business_type', 'user_stickers.sticker');
        return api_success('User Profile Interest', $data);
    }

    public function getBusinessProfile(Request $request)
    {
        $bid = $request->badge_id;
        $data = UserBadge::with('badge', 'user.user_events.event', 'user.user_challenges.challenge', 'user.user_offers.offer')->where('badge_id', $bid)->get();
        // ,'badge.business_user.challenges','badge.business_user.offers'
        return api_success('Badges Detail By ID', $data);
    }

    public function friendsData()
    {
        $tot = [];
        $suggested = [];
        $user = auth('api')->user();
        $data = $user->load('friend_requests', 'friends');

        foreach ($data->friend_requests as $request) {
            $tot[] = $request;
        }

        // for suggested friends
        $sug_friends = DB::select(
            "SELECT
            a.friend_id,
            COUNT(*) as relevance,
            GROUP_CONCAT(a.user_id ORDER BY a.user_id) as mutual_friends
            FROM
            friends a
            JOIN
            friends b
            ON  (
             b.friend_id = a.user_id
             AND b.user_id = " . auth('api')->user()->id . "
            )
            LEFT JOIN
            friends c
            ON
            (
             c.friend_id = a.friend_id
             AND c.user_id = " . auth('api')->user()->id . "
            )
            WHERE
            c.user_id IS NULL
            AND
            a.friend_id != " . auth('api')->user()->id . "
            GROUP BY
            a.friend_id
            ORDER BY
            relevance DESC"
        );

        foreach ($sug_friends as $sug_friend) {
            $suggested[] = User::where('id', $sug_friend->friend_id)->get();
        }

        $data['suggested_friends'] = $suggested;
        $data['total_requests'] = count($tot);

        $data['total_requests'] = count($tot);
        return api_success('Find Friends', $data);
    }

    public function getUserDidYouKnow()
    {
        $user = auth('api')->user();
        $data = $user->load('user_did_you_knows.did_you_know');
        return api_success('User did you know', $data);
    }

    // Followers & Followings
    public function getFollowers()
    {
        $user = auth('api')->user();

        $data = $user->load(['followers']);

        $followings = $this->getFollower($data->followers, 'IFollow');
        return api_success('Followers', $followings);
    }

    public function getFollowerRequests()
    {
        $user = auth('api')->user();

        $data = $user->load(['followerRequests']);
        // dd();
        $followings = $this->getFollower($data->followerRequests, 'IFollow');
        return api_success('Followers', $followings);
    }

    public function getFollower($followers, $callback)
    {
        $users = [];
        foreach ($followers as $k => $follower) {
            $users[$k]['id'] = $follower->id;
            $users[$k]['name'] = $follower->name;
            $users[$k]['username'] = $follower->username;
            $users[$k]['email'] = $follower->email;
            $users[$k]['avatar_url'] = $follower->avatar_url;
            $users[$k]['follow_back'] = $follower->{$callback}($follower->id);
        }

        return $users;
    }

    public function followUser()
    {
        $follow = false;
        if (request()->filled('follower_id')) {
            // check if its already following or not
            $f = Follower::where('follower_id', auth('api')->user()->id)->where('leader_id', request()->follower_id)->first();

            if ($f) {
                return api_error('Already following.');
            } else {
                $follow = Follower::create([
                    'follower_id' => auth('api')->user()->id,
                    'leader_id' => request()->follower_id
                ]);

                // \App\Chat\Soachat::addFriends(auth('api')->user()->id, request()->follower_id);

                // firebase notification to the user who is followed by this user
                //$ago = \Carbon\Carbon::createFromTimeStamp(strtotime($follow->created_at))->diffForHumans();
                $u = User::find(request()->follower_id);
                $title = "Follow Notification";
                $body = "@" . auth('api')->user()->username . ' - follows you';
                $u->notify(new PushNotification(
                    $title,
                    $body
                ));
            }
        }

        if ($follow) {
            return api_success('Successfully following', $follow);
        } else {
            return api_error('Failed to follow.');
        }
    }

    public function followRequest()
    {
        $follow = false;
        if (request()->filled('follower_id')) {
            // check if its already following or not
            $f = Follower::where('follower_id', auth('api')->user()->id)->where('leader_id', request()->follower_id)->first();

            if ($f) {
                return api_error('Already following.');
            } else {
                $follow = Follower::create([
                    'follower_id' => auth('api')->user()->id,
                    'leader_id' => request()->follower_id,
                    'status' => 2
                ]);

                // \App\Chat\Soachat::addFriends(auth('api')->user()->id, request()->follower_id);

                // firebase notification to the user who is followed by this user
                //$ago = \Carbon\Carbon::createFromTimeStamp(strtotime($follow->created_at))->diffForHumans();
                $u = User::find(request()->follower_id);
                $title = "Follow Request Notification";
                $body = "@" . auth('api')->user()->username . ' - following request';
                $u->notify(new PushNotification(
                    $title,
                    $body
                ));
            }
        }

        if ($follow) {
            return api_success('Successfully request sent', $follow);
        } else {
            return api_error('Failed to follow request.');
        }
    }

    public function cancelFollowRequest()
    {
        $follow = false;
        if (request()->filled('follower_id')) {
            // check if its already following or not
            $f = Follower::where('follower_id', auth('api')->user()->id)->where('leader_id', request()->follower_id)->first();

            if ($f) {

                Follower::where('follower_id', auth('api')->user()->id)->where('leader_id', request()->follower_id)->delete();

                return api_success('Successfully cancelled', []);
            } else {

                $f = Follower::where('follower_id', request()->follower_id)->where('leader_id', auth('api')->user()->id)->first();
                if ($f) {
                    Follower::where('follower_id', request()->follower_id)->where('leader_id', auth('api')->user()->id)->delete();
                    return api_success('Successfully cancelled', []);
                }
                return api_error('Not requested');
            }
        }

        if ($follow) {
            return api_success('Successfully unfollowed', []);
        } else {
            return api_error('Failed to unfollow.');
        }
    }

    public function acceptFollowRequest()
    {
        $follow = false;
        if (request()->filled('follower_id')) {
            // check if its already following or not
            $f = Follower::where('follower_id', request()->follower_id)->where('leader_id', auth('api')->user()->id)->first();

            if ($f) {

                $f->status = 1;
                $f->save();

                return api_success('Successfully accepted', []);
            } else {
                return api_error('Not requested');
            }
        }

        if ($follow) {
            return api_success('Successfully accepted', []);
        } else {
            return api_error('Failed to accept.');
        }
    }

    public function unfollowUser()
    {
        $follow = false;
        if (request()->filled('follower_id')) {
            // check if its already following or not
            $f = Follower::where('follower_id', auth('api')->user()->id)->where('leader_id', request()->follower_id)->first();

            if ($f) {

                Follower::where('follower_id', auth('api')->user()->id)->where('leader_id', request()->follower_id)->delete();

                $u = User::find(request()->follower_id);
                $title = "Unfollow Notification";
                $body = "@" . auth('api')->user()->username . ' - unfollows you';
                $u->notify(new PushNotification(
                    $title,
                    $body
                ));

                \App\Chat\Soachat::removeFriends(auth('api')->user()->id, request()->follower_id);

                return api_success('Successfully unfollowed', []);
            } else {
                return api_error('already not following');
            }
        }

        if ($follow) {
            return api_success('Successfully unfollowed', []);
        } else {
            return api_error('Failed to unfollow.');
        }
    }

    public function getFollowings()
    {
        $user = auth('api')->user();

        $data = $user->load('followings');

        $followings = $this->getFollower($data->followings, 'isFollowMe');

        return api_success('Followings', $followings);
    }

    //
    public function createUserBadge(CreateBadgeRequest $request)
    {
        if (auth('api')->check()) {

            $data = [
                'user_id' => auth('api')->user()->id,
                'name' => $request->name,
                'badge_language' => $request->badge_language,
                'location' => $request->location,
                'duration' => $request->duration,
                'is_privacy' => $request->is_privacy,
            ];

            if ($request->has('badge_image')) {
                $fileName = time() . '_' . $request->badge_image->getClientOriginalName();
                $filePath = $request->file('badge_image')->storeAs('badges', $fileName, 'public');
                $data['badge_image'] = env('APP_URL') . 'storage/' . $filePath;
            }

            Badge::create($data);

            return api_success('Badge', 'Badge created successfully');
        } else {
            return api_error('PLease login first');
        }
    }

    public function search()
    {
        $paginated = User::where('id', '!=', auth('api')->user()->id)
            ->where('user_type', 'user')
            ->where('username', 'like', '%' . request()->search . '%')
            ->paginate(10);


        $users = $paginated->map(function ($user) {
            $data['id'] = $user->id;
            $data['name'] = $user->name;
            $data['username'] = $user->username;
            $data['email'] = $user->email;
            $data['avatar_url'] = $user->avatar_url;
            $data['following'] = $user->IFollow($user->id);
            $data['follower'] = $user->isFollowMe($user->id);

            return $data;
        });

        $users = new LengthAwarePaginator($users, $paginated->total(), $paginated->perPage());
        return api_success('Search Result', $users);
    }

    public function getUserProfile(User $user)
    {

        $user = $user->load('user_badges');

        $data['id'] = $user->id;
        $data['name'] = $user->name;
        $data['username'] = $user->username;
        $data['email'] = $user->email;
        $data['avatar'] = $user->avatar;
        $data['bio'] = $user->bio;
        $data['following'] = $user->IFollow($user->id);
        $data['follower'] = $user->isFollowMe($user->id);
        $data['user_badges'] = $user->user_badges;
        $data['badges_count'] = count($user->user_badges);


        return api_success('User Profile', $data);
    }

    public function becomeAmbassader()
    {
        auth('api')->user()->is_ambassader = 1;
        auth('api')->user()->referal_code = $this->generateRandomString(9);
        auth('api')->user()->save();

        return api_success('Become Ambassader', ['referal_code' => auth('api')->user()->referal_code]);
    }

    public function getReferalCode()
    {

        if (auth('api')->user()->is_ambassader) {
            return api_success('Referal code', ['referal_code' => auth('api')->user()->referal_code]);
        }

        return api_error('Invalid Request! Not an ambassader', 422);
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }



    function point2point_distance($lat1, $lon1, $lat2, $lon2, $unit = 'K')
    {
        if (!$lat1 || !$lat2 || !$lon1 || !$lon2) {
            return '0';
        }
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public function getFriends(Request $request)
    {
        $data = auth('api')->user()->followers()->where('name', 'like', '%' . request('friend_search') . '%')->get();

        $followings = $this->getFollower($data, 'IFollow');

        $followings = array_filter($followings, function ($arr) {
            return $arr['follow_back'];
        });

        $followings = array_values($followings);
        return api_success('Followers', $followings);
    }

    public function sendResponse($result = 'null', $message)
    {
        $response = [
            'status' => 'Success',
            'message' => $message ?? null,
            'data'    => $result,
        ];

        return response($response, 200);
    }

    public function sendError($errorMessages, $errors = null, $code = 422)
    {
        $response = [
            'status' => 422,
            'message' => $errorMessages,
            'data' => $errors,

        ];

        return response($response, $code);
    }
}
