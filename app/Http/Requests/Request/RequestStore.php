<?php

namespace App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;

class RequestStore extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // بيانات مقدم الطلب (applicants)
            'applicant.full_name' => 'required|string|max:255',
            'applicant.email' => 'required|email',
            'applicant.phone' => 'required|string|max:20',
            'applicant.mobile_phone' => 'required|string|max:20',
            'applicant.address' => 'required|string',
            'applicant.national_id' => 'required|string|unique:applicants,national_id|max:50',

            // بيانات الطلب (requests)
            'request.category_id' => 'required|exists:categories,id',
            'request.branch_id' => 'required|exists:branches,id',
            'request.request_type_id' => 'required|exists:request_types,id',
            'request.request_status_id' => 'required|exists:request_statuses,id',
            'request.description' => 'required|string|max:500',
            'request.reference_code' => 'required|max:50',

            // المرفقات (attachments)
            'attachments.*' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ];
    }


}
