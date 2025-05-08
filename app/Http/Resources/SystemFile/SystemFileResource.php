<?php

namespace App\Http\Resources\SystemFile;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Request\RequestResource;

class SystemFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // 'uploaded_by' => new UserResource($this->whenLoaded('uploadByUser')),
            // 'request' => new RequestResource($this->whenLoaded('request')),
            // المرفقات (الجديدة)
            'file_path' => asset('storage/' . $this->file_path) ?? [],
            'created_at' => $this->created_at->toDateTimeString(), 
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
