<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class ReportStore extends FormRequest
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
            'generated_by' => 'required|exists:users,id',
            'report_type' => 'required|in:type1,type1',
            'data' => 'required|json',
        ];
    }

    public function messages(){
        return [
            'report_type.in'    => 'type name field must be type1 Or type1 ',
        ];
    }
}
