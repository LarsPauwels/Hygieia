<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\WithTemplate;

class Icon extends JsonResource {
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
            'image' => $this->image_url,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    public function with($request) {
       return WithTemplate::with();
    }
}