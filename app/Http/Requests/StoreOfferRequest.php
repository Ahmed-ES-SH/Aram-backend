<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
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
            'title_ar' => 'required|string', // العنوان بالعربية (مطلوب)
            'title_en' => 'required|string', // العنوان بالإنجليزية (مطلوب)
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif', // الصورة (اختياري)
            'description_ar' => 'nullable|string', // الوصف بالعربية (اختياري)
            'description_en' => 'nullable|string', // الوصف بالإنجليزية (اختياري)
            'code' => 'nullable|string|unique:offers,code', // كود الكوبون (فريد إذا كان موجوداً)
            'discount_value' => 'required|numeric|min:0', // قيمة الخصم (مطلوب، رقم موجب)
            'start_date' => 'required|date', // تاريخ البداية (مطلوب، تاريخ صالح)
            'end_date' => 'required|date|after_or_equal:start_date', // تاريخ النهاية (مطلوب، بعد أو يساوي تاريخ البداية)
            'is_active' => 'sometimes|boolean', // حالة العرض (اختياري، قيمة منطقية)
            'organization_id' => 'required|exists:organizations,id', // معرف المنظمة (مطلوب، موجود في جدول المنظمات)
            'category_id' => 'required|exists:categories,id', // معرف الفئة (مطلوب، موجود في جدول الفئات)
        ];
    }


    /**
     * رسائل الأخطاء المخصصة.
     */
    public function messages(): array
    {
        return [
            'title_ar.required' => 'حقل العنوان بالعربية مطلوب.',
            'title_en.required' => 'حقل العنوان بالإنجليزية مطلوب.',
            'image.image' => 'يجب أن يكون الملف المرفق صورة.',
            'image.mimes' => 'يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif.',
            'image.max' => 'يجب ألا تتجاوز الصورة 2 ميجابايت.',
            'code.unique' => 'كود الكوبون مستخدم بالفعل.',
            'discount_value.required' => 'حقل قيمة الخصم مطلوب.',
            'discount_value.numeric' => 'قيمة الخصم يجب أن تكون رقمًا.',
            'discount_value.min' => 'قيمة الخصم يجب أن تكون أكبر من أو تساوي الصفر.',
            'start_date.required' => 'حقل تاريخ البداية مطلوب.',
            'start_date.date' => 'تاريخ البداية يجب أن يكون تاريخًا صالحًا.',
            'end_date.required' => 'حقل تاريخ النهاية مطلوب.',
            'end_date.date' => 'تاريخ النهاية يجب أن يكون تاريخًا صالحًا.',
            'end_date.after_or_equal' => 'تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية.',
            'is_active.boolean' => 'حقل الحالة يجب أن يكون قيمة منطقية (true/false).',
            'organization_id.required' => 'حقل معرف المنظمة مطلوب.',
            'organization_id.exists' => 'المنظمة المحددة غير موجودة.',
            'category_id.required' => 'حقل معرف الفئة مطلوب.',
            'category_id.exists' => 'الفئة المحددة غير موجودة.',
        ];
    }
}
