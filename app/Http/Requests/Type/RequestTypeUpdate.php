<?php

namespace App\Http\Requests\Type;

use Illuminate\Foundation\Http\FormRequest;

class RequestTypeUpdate extends FormRequest
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
            'type_name' => 'in:إبلاغ,تظلم,شكوى,اقتراح,استفسار,ثناء',
            'description' => 'nullable|max:500'
        ];
    }


    public function messages(){
        return [
            'type_name.in' => 'حقل نوع الطلب يجب أن يكون واحدًا من: إبلاغ، تظلم، شكوى، اقتراح، استفسار أو ثناء',
        ];
    }
}
