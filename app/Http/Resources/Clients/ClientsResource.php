<?php

namespace App\Http\Resources\Clients;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'date_profiled' => $this->date_profiled,
            'primary_legal_counsel' => $this->primary_legal_counsel,
            'date_of_birth' => $this->date_of_birth,
            'profile_image' => $this->profile_image,
            'is_profile_image_uploaded' => $this->is_profile_image_uploaded,
            'case_details' => $this->case_details
        ];
    }
}
