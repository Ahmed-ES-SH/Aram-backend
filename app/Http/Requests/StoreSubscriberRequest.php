<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:subscribers,email', // التحقق من صحة البريد الإلكتروني وفحص ما إذا كان فريدًا
            'first_name' => 'nullable|string|max:255', // التحقق من صحة الاسم الأول (اختياري)
            'last_name' => 'nullable|string|max:255',  // التحقق من صحة الاسم الأخير (اختياري)
        ];
    }


    /**
     * الحصول على رسائل الخطأ المخصصة.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم مسبقًا.',
            'first_name.string' => 'الاسم الأول يجب أن يكون نصًا.',
            'first_name.max' => 'الاسم الأول يجب ألا يتجاوز 255 حرفًا.',
            'last_name.string' => 'الاسم الأخير يجب أن يكون نصًا.',
            'last_name.max' => 'الاسم الأخير يجب ألا يتجاوز 255 حرفًا.',
        ];
    }
}
