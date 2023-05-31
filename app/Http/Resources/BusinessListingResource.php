<?php

namespace App\Http\Resources;

use App\Models\BusinessType;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessListingResource extends JsonResource
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
            'status' =>   $this->status == 1  ? 'Active' : 'In Active',
            'user_type' => $this->user_type,
            'business_type' => $this->user_business_detail ? BusinessType::where('id',$this->user_business_detail->business_type_id)->pluck('business_type')->first() : null,
            'created_at' =>  $this->when(isset($this->created_at), $this->created_at ? $this->created_at->format('d/m/Y') : '', ''),
        ];
    }
}
