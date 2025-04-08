<?php

namespace App\Http\Requests\RStatus;

use Illuminate\Foundation\Http\FormRequest;

class RequestStatusStore extends FormRequest
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
            'status_name' => 'required|in:Processing,Resolved,Urgent,Pending',
            'description' => 'required|max:500'
        ];
    }


    public function messages(){
        return [
            'status_name.in'    => 'type name field must be Processing,Resolved,Urgent Or Pending ',
        ];
    }
}
