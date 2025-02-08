<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'location' => 'nullable',
            'phone_number' => 'required|string|max:15',
            'image' => 'nullable|image|max:2048', // تحقق من أن الصورة صحيحة
            'role' => 'nullable|string|max:50',
            'account_type' => 'nullable',
            'is_signed' => 'nullable',
            'is_promoter' => 'nullable'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'يرجى إدخال اسم المستخدم.',
            'name.string' => 'اسم المستخدم يجب أن يكون نصاً.',
            'name.max' => 'اسم المستخدم لا يمكن أن يتجاوز 255 حرفاً.',

            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
            'email.unique' => 'البريد الإلكتروني الذي أدخلته مسجل بالفعل في النظام.',

            'password.required' => 'يرجى إدخال كلمة المرور.',



            'phone_number.required' => 'يرجى إدخال رقم الهاتف.',

            'phone_number.string' => 'رقم الهاتف يجب أن يكون نصاً.',
            'phone_number.max' => 'رقم الهاتف لا يمكن أن يتجاوز 15 حرفاً.',

            'image.image' => 'يرجى إدخال صورة صحيحة.',
            'image.max' => 'حجم الصورة يجب أن لا يتجاوز 2 ميجابايت.',

            'role.string' => 'الدور يجب أن يكون نصاً.',
            'role.max' => 'الدور لا يمكن أن يتجاوز 50 حرفاً.',
        ];
    }
}
