<?php

namespace App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Request;


class RequestUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $currentRequest = $this->route('request');

        // إذا كان الطلب مرسلًا كمعرّف (ID)، استرجعه من قاعدة البيانات
        if (!($currentRequest instanceof Request)) {
            $currentRequest = Request::findOrFail($currentRequest);
        }

        $applicantId = $currentRequest->applicant_id;


        return [
            // بيانات مقدم الطلب (applicant)
            'applicant.full_name' => 'sometimes|string|max:255',
            'applicant.email' => 'sometimes|email',
            'applicant.phone' => 'sometimes|string|max:20',
            'applicant.mobile_phone' => 'sometimes|string|max:20',
            'applicant.address' => 'sometimes|string',
            'applicant.national_id' => [
                'sometimes', // التحقق فقط إذا أُرسل الحقل
                'string',
                'max:50',
                Rule::unique('applicants', 'national_id')->ignore($applicantId), // تجاهل التفرُّد للقيمة الحالية
                ],

            // بيانات الطلب (request)
            'request.category_id' => 'sometimes|exists:categories,id',
            'request.branch_id' => 'sometimes|exists:branches,id',
            'request.request_type_id' => 'sometimes|exists:request_types,id',
            'request.request_status_id' => 'sometimes|exists:request_statuses,id',
            'request.city_id' => 'sometimes|exists:cities,id',
            'request.description' => 'sometimes|string|max:500',
            'request.reference_code' => 'sometimes|max:50',

            // المرفقات (attachments) - اختيارية في التحديث
            'attachments.*' => 'sometimes|file|mimes:pdf,jpg,png|max:2048',
        ];
}

}
