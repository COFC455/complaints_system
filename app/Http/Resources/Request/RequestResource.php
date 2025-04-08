<?php

namespace App\Http\Resources\Request;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            //applicant
            'applicant' => [
                'id' => $this->applicant->id,
                'name' => $this->applicant->full_name,
            ],
           //category
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->category_name,
            ],
            //branch
            'branch' => [
                'id' => $this->branch->id,
                'name' => $this->branch->branch_name,
            ],
            //request_type
            'request_type' => [
                'id' => $this->request_type->id,
                'name' => $this->request_type->type_name,
            ],
            //request_status
            'request_status' => [
                'id' => $this->request_status->id,
                'name' => $this->request_status->status_name,
            ],
            'description' => $this->description,
            'reference_code' => $this->reference_code,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
