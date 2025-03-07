<?php

namespace App\Http\Requests;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email',
            'password' => 'sometimes|string',
            'phone_number' => 'sometimes|string|max:15',
            'image' => 'sometimes',
            'location' => 'sometimes|string',
            'role' => 'sometimes|string|max:50',
            'account_type' => 'sometimes',
            'user_gender' => 'sometimes|in:male,female',
            'user_birthdate' => 'sometimes|date',
            'is_signed' => 'sometimes',
            'is_promoter' => 'sometimes',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'يرجى إدخال اسم المستخدم.',
            'name.string' => 'اسم المستخدم يجب أن يكون نصًا.',
            'name.max' => 'اسم المستخدم لا يمكن أن يتجاوز 255 حرفًا.',

            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
            'email.unique' => 'البريد الإلكتروني الذي أدخلته مسجل بالفعل في النظام.',

            'password.string' => 'كلمة المرور يجب أن تكون نصًا.',
            'password.min' => 'كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل.',

            'phone_number.string' => 'رقم الهاتف يجب أن يكون نصًا.',
            'phone_number.max' => 'رقم الهاتف لا يمكن أن يتجاوز 15 حرفًا.',

            'image.image' => 'الملف المرفق يجب أن يكون صورة.',


            'role.string' => 'الدور يجب أن يكون نصًا.',
            'role.max' => 'الدور لا يمكن أن يتجاوز 50 حرفًا.',
        ];
    }
}
