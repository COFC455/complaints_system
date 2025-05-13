<?php

namespace App\Http\Requests\SystemFile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SystemFileUpdate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'systemFiles' => 'sometimes|array',
            'systemFiles.*' => [
                'sometimes',
                'file',
                'mimes:pdf,jpg,png,jpeg',
                'max:10240' // 10MB
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'systemFiles.*.file' => 'القيمة يجب أن تكون ملفًا',
            'systemFiles.*.mimes' => 'نوع الملف غير مسموح به. المسموح: :values',
            'systemFiles.*.max' => 'الحد الأقصى لحجم الملف: 10 ميجابايت'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'request_id' => $this->route('request_id'),
            'uploaded_by' => auth()->id()
        ]);
    }
}