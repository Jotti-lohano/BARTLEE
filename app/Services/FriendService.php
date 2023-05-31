<?php

namespace App\Services;

use App\Models\Friend;
use Illuminate\Validation\ValidationException;

class FriendService  {

    public function __construct() 
    {
        $this->model = new Friend;
    }

    public function request($request) 
    {
        $exists = Friend::where(function($q) use ($request) {
                $q->where('user_id', auth()->user()->id)->where('friend_id', $request->friend_id);
            })->orWhere(function($q) use ($request) {
                $q->where('user_id', $request->friend_id)->where('friend_id', auth()->user()->id);
            })->first();
        
        if(!$exists) {
            $this->model->user_id = auth()->user()->id;
            $this->model->friend_id = $request->friend_id;
            $this->model->accepted = $this->model::PENDING_STATUS;
            $this->model->save();
        } else {
            // handle if already sent request
        }

        return $this->model;
    }

    public function remove($request)
    {
        $friendRequest = $this->model->where('accepted', Friend::PENDING_STATUS)->where('user_id', auth()->user()->id)->first();

        if(!$friendRequest) {
            throw ValidationException::withMessages([
                'message' => ['Invalid Request'],
            ]);
        }
        
        return $friendRequest->delete();
    }

    public function accept($request)
    {
        $friendRequest = $this->model->where('accepted', Friend::PENDING_STATUS)->where('friend_id', auth()->user()->id)->first();

        if(!$friendRequest) {
            throw ValidationException::withMessages([
                'message' => ['Invalid Request'],
            ]);
        }

        $friendRequest->accepted = $this->model::ACTIVE_STATUS;
        return $friendRequest->save();

    }

    public function cancel($request)
    {
        $friendRequest = $this->model->where('accepted', Friend::PENDING_STATUS)->where('friend_id', auth()->user()->id)->first();

        if(!$friendRequest) {
            throw ValidationException::withMessages([
                'message' => ['Invalid Request'],
            ]);
        }

        return $friendRequest->delete();
    }

    public function unfriend($request)
    {
        $friend = $this->model->where('accepted', Friend::ACTIVE_STATUS)
                                        ->where(function($q) use ($request) {
                                            $q->where('user_id', auth()->user()->id)->where('friend_id', $request->friend_id);
                                        })->orWhere(function($q) use ($request) {
                                            $q->where('user_id', $request->friend_id)->where('friend_id', auth()->user()->id);
                                        })->first();
        
        if(!$friend) {
            throw ValidationException::withMessages([
                'message' => ['Invalid Request'],
            ]);
        }
        return $friend->delete();
    }

}
