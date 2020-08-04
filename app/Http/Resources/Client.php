<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\WithTemplate;
use App\Http\Resources\Space as SpaceResource;

class Client extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'email' => $this->email,
            'logo_path' => $this->logo_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'spaces' => SpaceResource::collection($this->spaces)
        ];
    }

    public function with($request) {
        return WithTemplate::with();
    }
}