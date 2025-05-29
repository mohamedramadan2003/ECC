<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class CoordinatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
       public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $isUpdate = $this->route('coordinator') !== null;
        $id = $this->route('coordinator'); 

        return [
            'coordinator_name' => ['nullable', 'string', 'regex:/^[\x{0600}-\x{06FF}\s]+$/u', 'max:150'],
            'phone_number' => ['nullable', 'string', 'regex:/^(01)[0-9]{9}$/', 'size:11', 'unique:coordinators,phone_number,' . $id],
        ];
    }

    public function messages()
    {
        return [
            'coordinator_name.string' => 'اسم الدكتور يجب أن يكون نصًا',
            'coordinator_name.regex' => 'اسم الدكتور يجب أن يحتوي فقط على الحروف العربية أو الفراغات',
            'coordinator_name.max' => 'اسم الدكتور يجب أن لا يتجاوز 150 حرفًا',

            'phone_number.string' => 'رقم الهاتف يجب أن يكون نصًا',
            'phone_number.unique' => 'رقم الهاتف هذا مسجل بالفعل',
            'phone_number.regex' => 'رقم الهاتف يجب أن يبدأ بـ 01 ويكون مكون من 11 رقمًا',
            'phone_number.size' => 'رقم الهاتف يجب أن يتكون من 11 رقمًا',
        ];
    }
}
