<?php

namespace App\Http\Requests\SystemFile;

use Illuminate\Foundation\Http\FormRequest;

class SystemFileStore extends FormRequest
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
                'request_id' =>  'required|exists:requests,id',
                'uploaded_by' => 'required|exists:users,id',
                'systemFiles.*' => 'required|file|mimes:pdf,jpg,png,jpeg|max:10000',
    
        ];
    }


    protected function prepareForValidation()
{
    $this->merge([
        'request_id' => $this->route('request_id')
    ]);
}
}
