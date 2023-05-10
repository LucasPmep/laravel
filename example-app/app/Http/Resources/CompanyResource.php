<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\PersonResource;
use App\Http\Resources\ActivitysectorResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'postalcode' => $this->postalcode,
            'city' => $this->city,
            'CA' => $this->CA,

            'people' => PersonResource::collection($this->whenLoaded('people')),
            'activitysectors' => ActivitysectorResource::collection($this->whenLoaded('activitysectors')),
        ];
    }
}
