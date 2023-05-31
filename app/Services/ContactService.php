<?php


namespace App\Services;

use App\Models\Contact;
use HelperConstants;
use App\Traits\UploadAble;

class ContactService  {

    public function __construct() 
    {
        $this->model = new Contact;
    }

    public function index()
    {
        return auth()->user()->contacts;
    }

    public function create($request) 
    {        
        
        foreach($request->detail as $k=>$rec) {
            
            $exists = Contact::where('phone', $rec['phone'])->where('user_id', auth()->user()->id)->first();

            if($exists) {
                $exists->name = $rec['name'];
                $exists->phone = $rec['phone'];
                $exists->user_id = auth()->user()->id;
                if($request->file('detail.'.$k.'.photo')) {
                    $saveFile = saveFile($request->file('detail.'.$k.'.photo'), HelperConstants::CONTACT_PHOTO_DIRECTORY,  HelperConstants::UPLOAD_DISK);
                    $exists->photo = $saveFile['fileName'];                    
                } else {
                    $exists->photo = '';
                }   

                $exists->save();
            } else {
                $data[$k]['name'] = $rec['name'];
                $data[$k]['phone'] = $rec['phone'];
                $data[$k]['user_id'] = auth()->user()->id;
                if($request->file('detail.'.$k.'.photo')) {
                    $saveFile = saveFile($request->file('detail.'.$k.'.photo'), HelperConstants::CONTACT_PHOTO_DIRECTORY,  HelperConstants::UPLOAD_DISK);
                    $data[$k]['photo'] = $saveFile['fileName'];                    
                } else {
                    $data[$k]['photo'] = '';
                }             
            }
        }

        if(isset($data) && count($data)) {
            auth()->user()->contacts()->insert($data);
        }

        return true;

    }


    public function show($id)
    {
        return $this->model->where('id', $id)->first();
    }
    

    public function getCommentByPost($post, $status, $pagination)
    {
        $comment = $this->model->where('post_id', $post->id)->with(['user', 'reactions.user']);        
        return $comment->paginate($pagination);
    }
}
