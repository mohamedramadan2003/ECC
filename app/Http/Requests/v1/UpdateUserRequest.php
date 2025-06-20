<?php

namespace App\Http\Requests\v1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name'  => ['required', 'string', 'max:80'],
            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($this->route('id')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'اسم المستخدم فارغ',
            'username.unique'   => 'الايميل موجود بالفعل',
        ];
    }
}
