<?php


namespace App\Services;

use Hash;
use App\Models\User;
use HelperConstants;
use App\Services\Common\UserService;


class AdminService extends UserService
{

    public function __construct()
    {
        $this->model = new User;
    }

    public function create(object $request)
    {

        // create admin user here
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['status'] = $this->model::ACTIVE_STATUS;
        $data['parent_id'] = 1; //auth()->user()->id;

        $user = $this->model->create($data);
        //grand permissions here

        return $user;
    }

    public function update($request)
    {
        $user = $this->model->find(auth()->user()->id);

        $user->name = $request->name;

        if ($request->has('avatar')) {

            // $user->logo ? deleteFile(HelperConstants::LOGO_DIRECTORY . $user->logo, HelperConstants::UPLOAD_DISK) : '';
            $saveFile = saveFile($request->avatar, HelperConstants::PROFILE_PHOTO_DIRECTORY,  HelperConstants::UPLOAD_DISK);
            $user->photo = $saveFile['fileName'];
        }


        // if ($request->has('password')) {
        //     $user->password = Hash::make($request->password);
        // }

        $user->save();

        return $user;
    }

}
