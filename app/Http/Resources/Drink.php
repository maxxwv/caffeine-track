<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DrinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'caffeine' => $this->caffeine,
            'servings' => $this->servings,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
