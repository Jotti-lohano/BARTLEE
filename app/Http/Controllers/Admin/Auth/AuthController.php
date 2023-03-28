<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\ForgotPassword;
use App\Models\Admin;
use App\Models\Admins;
use App\Models\PasswordReset;
use App\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $authenticated = Auth::guard('admin')->attempt($request->all());
        if($authenticated){
            return response()->json(['status'=>true, 'admin'=> Auth::guard('admin')->user() ,'msg'=>'Logged in successfully']);
        }else{
            return response()->json(['status'=>false,'msg'=>'Invalid email OR Password'],422);
        }
    }
    public function logout(){
    	Auth::guard('admin')->logout();
    }

    public function verify_email(Request $request){
        $admin = Admin::where('email',$request->email)->first();
        if($admin){            
            $code = str_shuffle(substr(Str::random(4).time(),-5));
            $admin->notify(new VerifyEmail($code));
            PasswordReset::whereEmail($request->email)->delete();
            PasswordReset::insert(['email'=>$request->email,'token'=>$code]);
            return response()->json(['status'=>true,'msg'=>'Password reset Code has been sent on you email please check in email']);
        }else{

            return response()->json(['status'=>false,'msg'=>'user with this email doesn\'t exists']);
        }
    }
    public function verify_code(Request $request){
        $code = ForgotPassword::where('token',$request->code)->first();
        if($code){

            return response()->json(['status'=>true,'msg'=>'code has been verified successfully']);
        }else{
            return response()->json(['status'=>false,'msg'=>'invalid code given OR may be verification code has been expired']);

        }
    }
    public function update_password(Request $request){
        $code = ForgotPassword::where('token',$request->code)->first();
        $admin = Admin::whereEmail($code->email)->first();
        $admin->password = bcrypt($request->password);
        $admin->save();
        
        return response()->json(['status'=>true,'msg'=>'Password changed successfully']);
        $code = ForgotPassword::where('token',$request->code)->delete();
    }

}
