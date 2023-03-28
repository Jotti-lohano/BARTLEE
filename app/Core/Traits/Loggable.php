<?php
namespace App\Core\Traits;

use App\Models\Activity;

trait Loggable{
    public function loggable(){
        return $this->morphMany(Activity::class,'loggable');
    }


    public function saveLog($params){
        $params = $params + [
            'user_id' => auth()->id()??$params['user_id']??null,
        ];
        return $this->loggable()->create($params);
    }
}
?>