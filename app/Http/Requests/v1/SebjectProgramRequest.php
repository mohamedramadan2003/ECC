<?php

namespace App\Http\Requests\v1;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SebjectProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user() && Auth::user()->usertype == 'admin';
    }

    public function rules(): array
    {
        return [
            'course_code' => ['required','string','max:10', 'regex:/^(?!.*<script>).*$/'],
            'course_name' =>['required','string','max:50', 'regex:/^(?!.*<script>).*$/'],
            'program_name'=>['required','string','max:50', 'regex:/^(?!.*<script>).*$/'],
            'ProgramType' => ['required','in:عادي,خاص', 'regex:/^(?!.*<script>).*$/'],
            'level'=>['required','in:الاول,الثاني,الثالث,الرابع', 'regex:/^(?!.*<script>).*$/'],
            'term'=>['required','in:الاول,الثاني', 'regex:/^(?!.*<script>).*$/'],
        ];
    }
    public function messages()
    {
        return [
            'course_name'=>'الاسم المادة مطلوب',
            'course_code.required'=>' الكود مطلوب',
            'program_name.required' => 'اسم البرنامج مطلوب.',
            'ProgramType.required' => 'نوع البرنامج مطلوب.',
            'ProgramType.in' => 'نوع البرنامج يجب أن يكون إما عادي أو خاص.',
            'department_id.required' => 'البرنامج يجب أن يتم اختياره.',
            'subject_id.required' => 'المادة يجب أن يتم اختيارها.',
            'level.required' => 'المستوى مطلوب.',
            'term.required' => 'الفصل الدراسي مطلوب.',
        ];
    }
}
