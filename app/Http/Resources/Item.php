<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\WithTemplate;
use App\Http\Resources\Space as SpaceResource;
use App\Space as SpaceModel;
use App\Http\Resources\Frequency as FrequencyResource;
use App\Frequency as FrequencyModel;
use App\Http\Resources\Procedure as ProcedureResource;
use App\Procedure as ProcedureModel;
use App\Http\Resources\Icon as IconResource;
use App\Icon as IconModel;

class Item extends JsonResource {
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'space' => new SpaceResource(SpaceModel::find($this->space_id)),
            'frequency' => new FrequencyResource(FrequencyModel::find($this->frequency_id)),
            'procedure' => new ProcedureResource(ProcedureModel::find($this->procedure_id)),
            'icon' => new IconResource(IconModel::find($this->image_id))
        ];
    }

    public function with($request) {
       return WithTemplate::with();
    }
}