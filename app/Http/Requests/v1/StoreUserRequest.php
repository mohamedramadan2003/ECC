<?php

namespace App\Http\Requests\v1;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:100'],
            'username'    => ['required', 'string', 'max:80', 'unique:users,username','regex:/^[a-zA-Z0-9_]+$/'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'اسم المستخدم فارغ',
            'username.unique'      => 'الايميل مسجل مسبقاً',
            'password.confirmed'=> 'كلمة المرور غير متطابقة',
            'username.regex'    => 'اسم المستخدم يجب أن يحتوي فقط على حروف، أرقام، أو الشرطة السفلية (_).',
        ];
    }
}
