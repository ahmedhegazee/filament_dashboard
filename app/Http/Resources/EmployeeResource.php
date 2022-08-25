<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'full_name' => $this->full_name,
            'department' => $this->department->name,
            'address' => $this->address,
            'zip_code' => $this->zip_code,
            'birth_date' => $this->birth_date,
            'hired_date' => $this->hired_date,
            'country' => $this->country->name,
            'state' => $this->state->name,
            'city' => $this->city->name,
        ];
    }
}