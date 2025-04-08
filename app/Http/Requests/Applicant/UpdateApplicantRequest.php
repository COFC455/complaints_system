<?php

namespace App\Http\Requests\Applicant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicantRequest extends FormRequest
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
        return [
            'full_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:applicants,email,' . $this->applicant->id,
            'phone' => 'sometimes|string|max:20',
            'mobile_phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
            // القاعدة تمنع تكرار الـ national_id في أي سجل ماعدا السجل الحالي الذي يتم تعديله.
            'national_id' => 'sometimes|string|unique:applicants,national_id,' . $this->applicant->id . '|max:20',
        ];
    }
}
