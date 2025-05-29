<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
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
            'courseCode'       => 'required|string|regex:/^[\pL0-9\s]+$/u|max:255',
            'professorCode'    => 'required|string|regex:/^[\pL0-9\s]+$/u|max:255',
            'department_id'    => 'required|array|min:1',
            'department_id.*'  => 'exists:departments,id',
        ];
    }

    public function messages(): array
    {
        return [
            'courseCode.required' => 'يرجى إدخال كود المادة.',
            'courseCode.string'   => 'كود المادة يجب أن يكون نصاً.',
            'courseCode.regex'    => 'كود المادة يجب أن يتكون من أرقام وحروف فقط.',
            'courseCode.max'      => 'كود المادة لا يمكن أن يتجاوز 255 حرفاً.',

            'professorCode.required' => 'يرجى إدخال رقم المنسق.',
            'professorCode.string'   => 'رقم المنسق يجب أن يكون نصاً.',
            'professorCode.regex'    => 'رقم المنسق يجب أن يتكون من أرقام وحروف فقط.',
            'professorCode.max'      => 'رقم المنسق لا يمكن أن يتجاوز 255 حرفاً.',

            'department_id.required' => 'يرجى إدخال البرنامج.',
            'department_id.array'    => 'صيغة البرنامج غير صحيحة.',
            'department_id.min'      => 'يرجى اختيار برنامج واحد على الأقل.',
            'department_id.*.exists' => 'البرنامج المختار غير موجود في قاعدة البيانات.',
        ];
    }
}
