<?php

namespace App\Http\Resources\RStatus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestStatusResource extends JsonResource
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
            'status_name' => $this->status_name,
            'description' => $this->description,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
