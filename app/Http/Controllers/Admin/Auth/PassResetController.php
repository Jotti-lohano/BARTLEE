<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use App\Notifications\PasswordResetRequest;

class PassResetController extends Controller
{
    //
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:admins,email',
        ]);
        $user = Admin::where('email', $request->email)->first();
        PasswordReset::where('email',$request->email)->delete();
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => substr(time(),-4)
            ]
        );
        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequest($user, $passwordReset->token)
            );
        return response()->json([
        	'status'=>true,
            'message' => 'We have sent you a verification code!'
        ]);
    }
    public function verify_code(Request $request){
        $code = PasswordReset::where('token',$request->code)->first();
        if($code){

            return response()->json(['status'=>true,'message'=>'code has been verified successfully']);
        }else{
            return response()->json(['status'=>false,'errors' => ['code'=>'this code is invalid']]);

        }
    }

    public function update_password(Request $request){
        $code = PasswordReset::where('token',$request->code)->first();
        if(!$code){
            return response()->json(['msg'=> 'invalid code given','status' => false],409);
        }
        $user = Admin::whereEmail($code->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();
        
        PasswordReset::where('token',$request->code)->where('email',$code->email)->delete();
        // $code = PasswordReset::where('token',$request->code)->delete();
        return response()->json(['status'=>true,'msg'=>'Password changed successfully']);
    }
}
