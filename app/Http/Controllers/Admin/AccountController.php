<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    
    public function update(Request $request ){

		$id = $request->id;
		$data = Admin::where('id', $id)->first();
		
		if ($request->has('file') && $request->file != '') {
			$fileName = time() . '_' . $request->file->getClientOriginalName();
			$filePathAvatar = $request->file('file')->storeAs('user/avatar', $fileName, 'public');
			$data->avatar = $fileName;
		}
		$data->name =  $request->name;
		$data->last_name = $request->last_name;
		$data->save();
		
		// $data =  $request->only(['name' , 'last_name']);

		// $admin = Admin::where('id' , $id)->update($data);
		$admin = auth()->guard('admin')->user();
    	return response()->json(['status'=> true,'msg'=>'Admin account has been Update successfully','user' => $admin]);
    }

    public function update_password(Request $request){
    	


    	if(Hash::check($request->current_password, auth('admin')->user()->password)){

			if(!($request->password == $request->password_confirmation))
			return response()->json(['status'=>false,'msg'=> 'New Passwords and Confirm Password does not match'],422);	

    		$user = auth('admin')->user();
    		$user->password =  bcrypt($request->password);
    		$user->save();
    		return response()->json(['status'=>true,'msg'=>'Password has been updated successfully']);
    	}
    		return response()->json(['status'=>false,'msg'=>'current password in not valid'],422);	

    }

    public function logout(Request $request){
        auth('admin')->logout();
        return response()->json(['status' => true,'msg'=>'Have a good day!']);
    }
}
