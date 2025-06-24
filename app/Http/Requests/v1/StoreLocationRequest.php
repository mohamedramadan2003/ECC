<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
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

        'committee_number' => 'required|integer|min:1|unique:locations,committee_number',
        'place_name' => 'required|string|max:255',
        'committee_code' => 'nullable|string|size:1|regex:/^[A-Z]$/',
        ];
    }

    public function messages()
{
    return [
        'committee_number.required' => 'رقم اللجنة مطلوب.',
        'committee_number.integer' => 'رقم اللجنة يجب أن يكون رقمًا صحيحًا.',
        'committee_number.min' => 'رقم اللجنة يجب أن يكون أكبر من صفر.',
        'committee_number.unique' => 'رقم اللجنة موجود بالفعل.',

        'place_name.required' => 'اسم المكان مطلوب.',
        'place_name.string' => 'اسم المكان يجب أن يكون نصًا.',
        'place_name.max' => 'اسم المكان يجب ألا يتجاوز 255 حرفًا.',

        'committee_code.string' => 'رمز اللجنة يجب أن يكون نصًا.',
        'committee_code.size' => 'رمز اللجنة يجب أن يكون حرفًا واحدًا فقط.',
        'committee_code.regex' => 'رمز اللجنة يجب أن يكون حرفًا إنجليزيًا كبيرًا فقط (A-Z).',
    ];
}

}
