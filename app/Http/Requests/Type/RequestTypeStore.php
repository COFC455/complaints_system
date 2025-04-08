<?php

namespace App\Http\Requests\Type;

use Illuminate\Foundation\Http\FormRequest;

class RequestTypeStore extends FormRequest
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
            'type_name' => 'required|in:Report,Grievance,Complaints,Suggestion,Enquiry,Tribute',
            'description' => 'required|max:500'
        ];
    }

    public function messages(){
        return [
            'type_name.in'    => 'type name field must be Report,Grievance,Complaints,Suggestion,Enquiry or Tribute ',
        ];
    }
}
