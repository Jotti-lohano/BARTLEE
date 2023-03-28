<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllReminderRecource extends JsonResource
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
            "reminderable_id" => $this->reminderable_id,
            "user_id" => $this->user_id,
            "reminder_date" => $this->reminder_date,
            "created_at" => $this->created_at,
            "status" => $this->status,
            "snooze_status" => $this->snooze_status,
            "going" => $this->going,
            "completed" => $this->completed,
            "later" => $this->later,
            "reminderable" =>$this->reminderable,
        ];
    }
}
