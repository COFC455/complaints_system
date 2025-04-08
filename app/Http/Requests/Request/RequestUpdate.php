<?php

namespace App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'applicant_id' => 'nullable|exists:applicants,id',
            'category_id' => 'nullable|exists:categories,id',
            'branch_id' => 'nullable|exists:branches,id',
            'request_type_id' => 'nullable|exists:request_types,id',
            'request_status_id' => 'nullable|exists:request_statuses,id',
            'description' => 'nullable|max:500',
            'reference_code' => 'nullable||max:50',
        ];
}

}
