<?php

namespace App\Http\Requests\v1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
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
              'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('Departments', 'name')->ignore($this->id),
        ],
            'ProgramType' => 'required|in:عادي,خاص',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'الاسم هو حقل مطلوب',
            'name.string'    => 'الاسم يجب أن يكون نصًا',
            'name.max'       => 'الاسم يجب أن لا يتجاوز 255 حرفًا',
            'name.unique'    => 'الاسم هذا مسجل مسبقًا في النظام',

            'ProgramType.required' => 'نوع البرنامج هو حقل مطلوب',
            'ProgramType.in'       => 'نوع البرنامج يجب أن يكون إما "عادي" أو "خاص"',
        ];
    }
}
