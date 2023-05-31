<?php


namespace App\Services;

use App\Models\Reaction;

class ReactionService {

    public function __construct() 
    {
        $this->model = new Reaction;
    }

    public function create($model, $request) 
    {

        $exists = Reaction::where('reactable_type', $model)->where('reactable_id', $request->id)->where('type', $request->type)->exists();
        
        if(!$exists) {

            $this->model->reactable_type = $model;
            $this->model->reactable_id = $request->id;
            $this->model->type = $request->type;
    
            $reaction = auth()->user()->reactTo()->save($this->model);
        } else {
            return 'Already react';
        }

        return $reaction;     
    }

    public function show($id)
    {
        return $this->model->where('id', $id)->first();
    }
    
    public function showReactionByType($model, $status, $pagination)
    {
        return Reaction::where('reactable_type', get_class($model))->where('reactable_id', $model->id)->with(['user'])->paginate();
    }

    public function removeReactionByType($model, $request)
    {
        return Reaction::where('reactable_type', $model)
                        ->where('reactable_id', $request->id)
                        ->where('user_id', auth()->user()->id)
                        ->where('type', $request->type)
                        ->delete();
    }
}
