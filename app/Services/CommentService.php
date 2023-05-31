<?php


namespace App\Services;

use App\Models\Comment;

class CommentService  {

    public function __construct() 
    {
        $this->model = new Comment;
    }

    public function create($request) 
    {
        $this->model->post_id = $request->post_id;
        $this->model->description = $request->description ? $request->description : '';
        $this->model->parent_id = $request->comment_id ? $request->comment_id : null;
        $comment = auth()->user()->comments()->save($this->model);

        return $comment->load('user');        
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
