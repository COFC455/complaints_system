<?php

namespace App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Request;
use App\Models\Applicant;

class RequestUpdate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data' => 'sometimes|json',
            'attachments.*' => 'sometimes|file|mimes:pdf,jpg,png|max:10240',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('data')) {
            $data = json_decode($this->input('data'), true);
            $this->merge($data);
        }
    }

    public function withValidator($validator)
    {
        $currentRequest = $this->route('request');

        // التأكد من أن $currentRequest هو نسخة من نموذج Request
        if (!($currentRequest instanceof Request)) {
            $currentRequest = Request::findOrFail($currentRequest);
        }

        $applicantId = $currentRequest->applicant_id;

        // ━━━━━━━━━━━━━━━━━━ التحقق من بيانات مقدم الطلب ━━━━━━━━━━━━━━━━━━
        $validator->sometimes('applicant.full_name', 'string|max:255', function ($input) {
            return isset($input['applicant']['full_name']);
        });

        $validator->sometimes('applicant.email', 'email', function ($input) {
            return isset($input['applicant']['email']);
        });

        $validator->sometimes('applicant.phone', 'string|max:20', function ($input) {
            return isset($input['applicant']['phone']);
        });

        $validator->sometimes('applicant.mobile_phone', 'string|regex:/^09\d{8}$/|max:10', function ($input) {
            return isset($input['applicant']['mobile_phone']);
        });

        // التحقق من الرقم الوطني مع تجاهل الرقم الحالي لمقدم الطلب
        $validator->sometimes('applicant.national_id', [
            'string',
            'max:50',
            Rule::unique('applicants', 'national_id')->ignore(Applicant::find($applicantId)->national_id, 'national_id'),
        ], function ($input) {
            return isset($input['applicant']['national_id']);
        });

        // ━━━━━━━━━━━━━━━━━━━━ التحقق من بيانات الطلب ━━━━━━━━━━━━━━━━━━━━
        $validator->sometimes('request.category_id', 'exists:categories,id', function ($input) {
            return isset($input['request']['category_id']);
        });

        $validator->sometimes('request.branch_id', 'exists:branches,id', function ($input) {
            return isset($input['request']['branch_id']);
        });

        $validator->sometimes('request.request_type_id', 'exists:request_types,id', function ($input) {
            return isset($input['request']['request_type_id']);
        });

        $validator->sometimes('request.request_status_id', 'exists:request_statuses,id', function ($input) {
            return isset($input['request']['request_status_id']);
        });

        $validator->sometimes('request.city_id', 'exists:cities,id', function ($input) {
            return isset($input['request']['city_id']);
        });

        $validator->sometimes('request.description', 'string|max:500', function ($input) {
            return isset($input['request']['description']);
        });

       // التحقق من رمز الإشارة مع تجاهل الرمز الحالي للطلب
        $validator->sometimes('request.reference_code', [
            'max:50',
            Rule::unique('requests', 'reference_code')->ignore($currentRequest->id),
        ], function ($input) {
            return isset($input['request']['reference_code']);
        });

        // إضافة التحقق للحقول الجديدة
        $validator->sometimes('request.is_received', 'boolean', function ($input) {
            return isset($input['request']['is_received']);
        });

        $validator->sometimes('request.concerned_entities', [
            Rule::in(['الجهاز المركزي', 'غير ذلك']),
        ], function ($input) {
            return isset($input['request']['concerned_entities']);
        });

        $validator->sometimes('request.user_id', 'exists:users,id', function ($input) {
            return isset($input['request']['user_id']);
        });
    }

    public function messages()
    {
        return [
            'data.required' => 'حقل البيانات مطلوب',
            'data.json' => 'يجب أن تكون البيانات بتنسيق JSON صالح',
            'applicant.mobile_phone.regex' => 'رقم الهاتف يجب أن يبدأ بـ 09 ويحتوي على 10 أرقام',
            'applicant.national_id.unique' => 'الرقم الوطني مُستخدم مسبقًا',
            'request.reference_code.unique' => 'رمز الإشارة مُستخدم مسبقًا',
            'request.is_received.boolean' => 'يجب أن تكون قيمة الاستلام 0 أو 1',
            'request.concerned_entities.in' => 'القيمة المحددة غير مسموحة (الخيارات: الجهاز المركزي، غير ذلك)',
            'request.user_id.exists' => 'المستخدم المحدد غير موجود',
            'request.category_id.exists' => 'الفئة المحددة غير موجودة',
            'request.branch_id.exists' => 'الفرع المحدد غير موجود',
            'request.request_type_id.exists' => 'نوع الطلب المحدد غير موجود',
            'request.request_status_id.exists' => 'حالة الطلب المحددة غير موجودة',
            'request.city_id.exists' => 'المدينة المحددة غير موجودة',
        ];
    }
}
