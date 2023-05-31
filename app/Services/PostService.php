<?php


namespace App\Services;

use Hash;
use App\Models\Post;
use HelperConstants;
use App\Models\Comment;
use App\Models\Reaction;
use App\Models\PostImage;
use App\Traits\UploadAble;

class PostService
{
    use UploadAble;

    public function __construct()
    {
        $this->model = new Post;
    }

    public function show($id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function create(object $request) 
    {
        // create event post here
        $this->model->user_id = auth()->user()->id;
        $this->model->contact_id = $request->contact_id;
        $this->model->contact_name = $request->contact_name;
        $this->model->is_public = $request->visibility;
        $this->model->content = $request->content ? $request->content : '';        
        $this->model->status = $this->model::ACTIVE_STATUS;

        $eventPost = auth()->user()->post()->save($this->model);

        // Associate Post Media 

        if($request->has('upload')) {
            foreach($request->upload as $file) {
                $this->uploadOneAndSave($eventPost, $file, HelperConstants::EVENT_POST_DIRECTORY,  HelperConstants::UPLOAD_DISK);
            }            
        }

        return $eventPost;
    }

    public function update($request)
    {
        $post = $this->show($request->post_id);
        $post->content = $request->content ? $request->content : '';
        $post->contact_id = $request->contact_id;
        $post->contact_name = $request->contact_name;
        $post->is_public = $request->visibility;

        $post->save();

        $this->removeMedia($post, $request->old_files ? $request->old_files : []);

        // Associate Post Media 
        $this->uploadMedia($request, $post);

        return $post;
    }

    public function delete($request)
    {
        $post = EventPost::where('id',$request)->delete();

    }

    public function statusUpdate($request, $action)
    {
        $post = $this->show($request->post_id);

        $post->status = $action == 'accept' ? $this->model::ACTIVE_STATUS : $this->model::REJECTED_STATUS;
        $post->save();
    }

   

    public function uploadMedia($request, $model)
    {
        if($request->has('upload')) {
            foreach($request->upload as $file) {
                $this->uploadOneAndSave($model, $file, HelperConstants::EVENT_POST_DIRECTORY,  HelperConstants::UPLOAD_DISK);
            }            
        }
    }

    public function removeMedia($model, $unChangeFiles = [])
    {
        $files = $model->files()->whereNotIn('id', $unChangeFiles)->get();
        
        foreach($files as $file) {
            deleteFile(HelperConstants::EVENT_POST_DIRECTORY.$file->path, HelperConstants::UPLOAD_DISK);
        }

        $model->files()->whereNotIn('id', $unChangeFiles)->delete();
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function listing($request)
    {
        return $this->model->when(isset($request->search), function($q) use ($request){
            $q->where('content', 'like', '%'.$request->search.'%');
        })->paginate();
    }

    public function homeData($request)
    {
        return $this->model->where('status', 1)->with(['comments.user', 'reactions.user', 'contact'])->orderBy('created_at', 'Desc')->paginate();
    }
}
