<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Features;
use App\Models\UserArtist;
use Illuminate\Http\Resources\Json\JsonResource;

class paymentResource extends JsonResource
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
            'total_amount'=> $this->amount,
            'status' =>$this->status,
            'expiry_date' => $this->feature_expiry_date,
            'is_featured' => Carbon::now() > $this->feature_expiry_date ? 'Not-Featured' : 'Featured',
            'feature_id' =>   $this->package_id,
            'transitionable_id' =>$this->transitionable_id,
            'feature' => Features::find($this->package_id),
            'created_at' =>  $this->when(isset($this->created_at), $this->created_at ? $this->created_at->format('d/m/Y') : '', ''),
            'user_artist' => UserArtist::select('id','user_profile_id','is_featured')->find($this->transitionable_id),
        ];
    }
}
