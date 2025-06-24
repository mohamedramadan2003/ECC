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
            'department_id'    => 'required|exists:departments,id',
             'committees' => 'required|array|min:1',
            'committees.*.numbers' => 'required|integer|min:0|exists:locations,committee_number',
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
            'department_id.min'      => 'يرجى اختيار برنامج واحد على الأقل.',
            'department_id.*.exists' => 'البرنامج المختار غير موجود في قاعدة البيانات.',
            'committees.required' => 'يجب إدخال بيانات اللجان.',
            'committees.array' => 'بيانات اللجان يجب أن تكون على شكل مصفوفة.',
            'committees.min' => 'يجب إدخال لجنة واحدة على الأقل.',

            'committees.*.numbers.required' => 'رقم اللجنة مطلوب.',
            'committees.*.numbers.integer' => 'رقم اللجنة يجب أن يكون عددًا صحيحًا.',
            'committees.*.numbers.min' => 'رقم اللجنة لا يمكن أن يكون سالبًا.',
            'committees.*.numbers.exists' => 'رقم اللجنة غير موجود .',

        ];
    }
}
