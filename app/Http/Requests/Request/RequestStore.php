<?php

namespace App\Http\Requests\Request;

use Illuminate\Foundation\Http\FormRequest;

class RequestStore extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

           'data' => 'required|json',
            // المرفقات (attachments)
            'attachments.*' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ];
    }


}
