<?php

namespace App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreOnlyRequest extends FormRequest
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
            'applicant_id' => 'required|exists:applicants,id',
            'category_id' => 'required|exists:categories,id',
            'branch_id' => 'required|exists:branches,id',
            'request_type_id' => 'required|exists:request_types,id',
            'request_status_id' => 'required|exists:request_statuses,id',
            'city_id' => 'required|exists:cities,id',
            'status' => 'required|in:active,inactive',
            'description' => 'required|max:500',
            'reference_code' => 'required||max:50',
        ];
    }
}
