<?php

namespace App\Http\Resources;

use App\Models\Profession;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfessionResource extends JsonResource
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
            'profession' =>  Profession::where('id',$this->artist_profession)->pluck('Profession')->first(),
        ];
    }
}
