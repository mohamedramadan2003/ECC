<?php

namespace App\Http\Requests\v1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
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
        $subjectId = $this->route('id'); // أو $this->subject

        return [
            'code'         => [
                'required',
                'string',
                'max:255',
                'regex:/^\S*$/u',
                Rule::unique('subjects', 'code')->ignore($subjectId),
            ],
            'subject_name' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'الكود هو حقل مطلوب',
            'code.string'   => 'الكود يجب أن يكون نصًا',
            'code.max'      => 'الكود يجب أن لا يتجاوز 255 حرفًا',
            'code.unique'   => 'الكود هذا مسجل مسبقًا في النظام',
            'code.regex'    => 'الكود يجب أن يحتوي فقط على أحرف بدون فراغات',

            'subject_name.required' => 'اسم المادة هو حقل مطلوب',
            'subject_name.string'   => 'اسم المادة يجب أن يكون نصًا',
            'subject_name.max'      => 'اسم المادة يجب أن لا يتجاوز 255 حرفًا',
        ];
    }
}
