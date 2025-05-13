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
        //المستخدم
        'user' => [
            'id' => $this->user->id ?? null,
            'name' => $this->user->name ?? 'غير محدد',
        ],
        // المحافظة
        'city' => [
            'id' => $this->city->id ?? null,
            'name' => $this->city->city_name ?? 'غير محدد',
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

        //tracking
        'trackings' => $this->trackings->map(function ($tracking) {
            return [
                'id' => $tracking->id,
                'comment' => $tracking->comment,
                'status' => $tracking->request_status->status_name ?? 'غير محدد',
                'updated_by' => [
                    'id' => $tracking->updatedByUser->id ?? null,
                    'name' => $tracking->updatedByUser->name ?? 'غير معروف',
                ],
                'created_at' => $tracking->created_at->toDateTimeString(),
            ];
        }) ?? [],
            'description' => $this->description,
            'reference_code' => $this->reference_code,
            'is_received'    => $this->is_received,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
