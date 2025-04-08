<?php

namespace App\Http\Requests\Traking;

use Illuminate\Foundation\Http\FormRequest;

class TrakingUpdate extends FormRequest
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
            'request_id' => 'nullable|exists:requests,id',
            'updated_by' => 'nullable|exists:users,id',
            'request_status_id' => 'nullable|exists:request_statuses,id',
            'comment' => 'nullable|max:500',
        ];
    }
}
