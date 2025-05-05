<?php

namespace App\Http\Requests\RStatus;

use Illuminate\Foundation\Http\FormRequest;

class RequestStatusUpdate extends FormRequest
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
            'status_name' => 'in:قيد المعالجة,تم الحل,عاجلة,فيد الانتظار,متوقفة,ملغية',
            'description' => 'nullable|max:500'
        ];
    }

    public function messages(){
        return [
            'status_name.in' => 'حقل حالة الطلب يجب أن يكون واحدًا من: قيد المعالجة، تم الحل، عاجلة، قيد الانتظار، متوقفة أو ملغية',
        ];
    }
}
