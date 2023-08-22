<?php

namespace App\Http\Resources;


use App\Models\UserArtist;
use App\Http\Resources\ProfessionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistListingResource extends JsonResource
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
            'id' => $this->id,
            'first_name' => $this->first_name,
            'email' => $this->when(isset($this->email), $this->email),            
            'status' =>   $this->status ,
            'user_type' => $this->user_type,
            'user_artist' =>  UserArtist::where('user_profile_id',$this->id)->first(),
            'Profession'=> new ProfessionResource(UserArtist::where('user_profile_id',$this->id)->first()),
             'created_at' =>  $this->when(isset($this->created_at), $this->created_at ? $this->created_at->format('d/m/Y') : '', ''),
        ];
    }
}
