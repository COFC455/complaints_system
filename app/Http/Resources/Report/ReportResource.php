<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'generated_by' => $this->generated_by,
            'report_type' => $this->report_type,
           'data' => json_decode($this->data, true) ?? null,
            'generatedUser' => [
                'id' => $this->generatedUser->id,
                'name' => $this->generatedUser->name,
            ],
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
