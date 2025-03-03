<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreorganizationRequest extends FormRequest
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
            'email' => 'required|email|unique:organizations,email',
            'password' => 'required',
            'title_ar' => 'required|string|max:255|unique:organizations,title_en',
            'title_en' => 'required|string|max:255|unique:organizations,title_ar',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'location' => 'nullable|string',
            'categories_ids' => 'nullable', // التأكد من أن الفئة موجودة
            'features' => 'nullable|string',
            'accaptable_message' => 'string|nullable',
            'unaccaptable_message' => 'string|nullable',
            'category_id' => 'nullable', // التأكد من أن الفئة موجودة
            'confirmation_price' => 'nullable', // التأكد من أن الفئة موجودة
            'open_at' => 'nullable', // التأكد من أن الفئة موجودة
            'close_at' => 'nullable', // التأكد من أن الفئة موجودة
            'phone_number' => 'nullable|string|max:15|regex:/^[0-9+\-\s]+$/', // قبول أرقام الهواتف فقط
            'url' => 'nullable|url', // التأكد من صحة الرابط إذا وُجد
            'image' => 'nullable|image|file', // التأكد من أن الملف صورة
            'icon' => 'nullable|image|file', // التأكد من أن الملف أيقونة
            'account_type' => 'nullable',
            'is_signed' => 'nullable'
        ];
    }


    /**
     * تخصيص رسائل الأخطاء.
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'يجب إدخال البريد الإلكترونى.',
            'email.unique' => 'البريد الإلكترونى مستخدم بالفعل .',
            'title_en.unique' => ' هذا الاسم مستخدم بالفعل مستخدم بالفعل .',
            'title_ar.unique' => ' هذا الاسم مستخدم مستخدم بالفعل .',
            'image.required' => 'يجب إدخال  صورة رئيسية للمركز.',
            'icon.required' => 'يجب إدخال  شعار المركز.',
            'password.required' => 'يجب إدخال كلمة السر   .',
            'title_ar.required' => 'يجب إدخال العنوان باللغة العربية.',
            'title_en.required' => 'يجب إدخال العنوان باللغة الإنجليزية.',
            'description_ar.required' => 'يجب إدخال الوصف باللغة العربية.',
            'description_en.required' => 'يجب إدخال الوصف باللغة الإنجليزية.',
            'location.required' => 'يجب إدخال الموقع.',
            'categories_ids.required' => 'يجب اختيار التخصصات الخاصة بالمركز.',
            'phone_number.required' => 'يجب إدخال رقم الهاتف.',
            'open_at.required' => 'يجب إدخال  وقت عمل المركز.',
            'close_at.required' => 'يجب إدخال  وقت إغلاق المركز.',
            'phone_number.regex' => 'صيغة رقم الهاتف غير صحيحة.',
            'url.url' => 'الرابط يجب أن يكون صالحًا.',
            'image.image' => 'يجب أن يكون الملف صورة.',
            'image.mimes' => 'يجب أن تكون الصورة بامتداد jpeg, png, jpg, أو gif.',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميغابايت.',
            'icon.image' => 'يجب أن يكون الملف أيقونة صورة.',
            'icon.mimes' => 'يجب أن تكون الأيقونة بامتداد jpeg, png, jpg, أو gif.',
            'icon.max' => 'حجم الأيقونة يجب ألا يتجاوز 1 ميغابايت.',
            'features.required' => 'يجب اضافة بعض المميزات الى المركز الجديد',
        ];
    }
}
