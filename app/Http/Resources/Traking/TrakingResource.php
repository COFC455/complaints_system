<?php

namespace App\Http\Resources\Traking;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class TrakingResource extends JsonResource
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
            'requests' => $this->requests,
            'updated_by' => $this->updatedByUser,
            'request_status' => $this->request_status,
            'comment' => $this->comment,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
