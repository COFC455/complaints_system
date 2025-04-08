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
              // بيانات مقدم الطلب
        'applicant' => [
            'id' => $this->applicant->id ?? null,
            'name' => $this->applicant->full_name ?? 'غير معروف',
        ],
        // الفئة
        'category' => [
            'id' => $this->category->id ?? null,
            'name' => $this->category->category_name ?? 'غير محدد',
        ],
        // الفرع
        'branch' => [
            'id' => $this->branch->id ?? null,
            'name' => $this->branch->branch_name ?? 'غير محدد',
        ],
        // نوع الطلب
        'request_type' => [
            'id' => $this->request_type->id ?? null,
            'name' => $this->request_type->type_name ?? 'غير محدد',
        ],
        // حالة الطلب
        'request_status' => [
            'id' => $this->request_status->id ?? null,
            'name' => $this->request_status->status_name ?? 'غير محدد',
        ],

             // المرفقات (الجديدة)
            'attachments' => optional($this->applicant_attachments)->map(function ($applicant_attachments) {
            return [
                'id' => $applicant_attachments->id,
                'file_path' => asset('storage/' . $applicant_attachments->file_path),
            ];
        }) ?? [],

            'description' => $this->description,
            'reference_code' => $this->reference_code,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
