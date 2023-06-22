<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->data['title'],
            // "avatar" => isset($this->data['data']['image']) ? $this->data['data']['image'] : 'http://localhost:3000/mournify/static/media/headerlogo.d0f7476382f1c9260b7b.png',
            'message' => $this->data['body'],
   
            "created_at" => $this->created_at->format('Y-m-d'),
            "time" => $this->created_at->diffForHumans() ,
            "read" => $this->read_at ? false : true

        ];
    }
}
