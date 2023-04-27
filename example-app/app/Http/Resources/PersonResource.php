<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'email' => $this->email,
            'phone' => $this->phone,
            'civility_id' => $this->civility_id,
            'company_id' => $this->company_id,
            'company' => CompanyResource::make($this->whenLoaded('company')) ?? '',
            'civility' => CivilityResource::make($this->whenLoaded('civility')) ?? '',
            'departements' => DepartementResource::collection($this->whenLoaded('departements')),
        ];
    }
}
