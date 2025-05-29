<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamRequest extends FormRequest
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
            'courseCode'      => 'required|exists:subjects,code',
            'professorCode'   => 'required|exists:coordinators,phone_number',
            'exam_date'       => 'required|date|after_or_equal:today',
            'department_id'   => 'required|array|min:1',
            'department_id.*' => 'exists:departments,id',
        ];
    }

    public function messages(): array
    {
        return [
            'courseCode.required'      => 'يرجى إدخال كود المادة.',
            'courseCode.exists'        => 'كود المادة المدخل غير موجود في قاعدة البيانات.',

            'professorCode.required'   => 'يرجى إدخال رقم هاتف الدكتور.',
            'professorCode.exists'     => 'رقم هاتف الدكتور المدخل غير موجود في قاعدة البيانات.',

            'exam_date.required'       => 'يرجى إدخال تاريخ الامتحان.',
            'exam_date.date'           => 'يرجى إدخال تاريخ صالح للامتحان.',
            'exam_date.after_or_equal' => 'تاريخ الامتحان يجب أن يكون اليوم أو في المستقبل.',

            'department_id.required'   => 'يرجى تحديد القسم.',
            'department_id.array'      => 'صيغة القسم غير صحيحة.',
            'department_id.min'        => 'يرجى تحديد قسم واحد على الأقل.',
            'department_id.*.exists'   => 'القسم المدخل غير موجود في قاعدة البيانات.',
        ];
    }
}
