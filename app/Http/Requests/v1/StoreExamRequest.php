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
            'exam_date'       => 'required|date',
            'department_id'   => 'required|exists:departments,id',
            'committees' => 'required|array|min:1',
            'committees.*.numbers' => 'required|integer|min:0|exists:locations,committee_number',
            'committees.*.students' => 'required|integer|min:0',
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

            'department_id.required'   => 'يرجى تحديد القسم.',
            'department_id.min'        => 'يرجى تحديد قسم واحد على الأقل.',
            'department_id.*.exists'   => 'القسم المدخل غير موجود في قاعدة البيانات.',

             'committees.required' => 'يجب إدخال بيانات اللجان.',
            'committees.array' => 'بيانات اللجان يجب أن تكون على شكل مصفوفة.',
            'committees.min' => 'يجب إدخال لجنة واحدة على الأقل.',

            'committees.*.numbers.required' => 'رقم اللجنة مطلوب.',
            'committees.*.numbers.integer' => 'رقم اللجنة يجب أن يكون عددًا صحيحًا.',
            'committees.*.numbers.min' => 'رقم اللجنة لا يمكن أن يكون سالبًا.',

            'committees.*.students.required' => 'عدد الطلاب مطلوب.',
            'committees.*.students.integer' => 'عدد الطلاب يجب أن يكون عددًا صحيحًا.',
            'committees.*.students.min' => 'عدد الطلاب لا يمكن أن يكون سالبًا.',
            'committees.*.numbers.exists' => 'رقم اللجنة غير موجود .',
        ];
    }
}
