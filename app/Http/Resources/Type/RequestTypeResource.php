<?php

namespace App\Http\Resources\Type;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'type_name' => $this->type_name,
            'description' => $this->description,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
