<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
{
    /**
     * تحديد إذا كان المستخدم مصرح له بتنفيذ هذا الطلب.
     */
    public function authorize(): bool
    {
        // يمكنك تغيير هذا إلى `true` إذا كنت تريد السماح للجميع بالوصول
        // أو إضافة منطق للتحقق من الصلاحيات.
        return true;
    }

    /**
     * قواعد التحقق من البيانات.
     */
    public function rules(): array
    {
        return [
            'title_ar' => 'sometimes|string', // العنوان بالعربية (اختياري)
            'title_en' => 'sometimes|string', // العنوان بالإنجليزية (اختياري)
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif', // الصورة (اختياري)
            'description_ar' => 'nullable|string', // الوصف بالعربية (اختياري)
            'description_en' => 'nullable|string', // الوصف بالإنجليزية (اختياري)
            'code' => 'sometimes|string|unique:offers,code,' . $this->offer, // كود الكوبون (فريد إذا كان موجوداً، مع تجاهل الكود الحالي)
            'usage_limit' => 'sometimes',
            'discount_value' => 'sometimes|numeric|min:0', // قيمة الخصم (اختياري، رقم موجب)
            'start_date' => 'sometimes|date', // تاريخ البداية (اختياري، تاريخ صالح)
            'end_date' => 'sometimes|date|after_or_equal:start_date', // تاريخ النهاية (اختياري، بعد أو يساوي تاريخ البداية)
            'is_active' => 'sometimes|boolean', // حالة العرض (اختياري، قيمة منطقية)
            'status' => 'string|in:waiting,expired,active', // حالة العرض (اختياري، قيمة منطقية)
            'organization_id' => 'sometimes|exists:organizations,id', // معرف المنظمة (اختياري، موجود في جدول المنظمات)
            'category_id' => 'sometimes|exists:service_categories,id', // معرف الفئة (اختياري، موجود في جدول الفئات)
          	'card_type_id' => 'nullable',
        ];
    }

    /**
     * رسائل الأخطاء المخصصة.
     */
    public function messages(): array
    {
        return [
            'title_ar.string' => 'حقل العنوان بالعربية يجب أن يكون نصًا.',
            'title_ar.max' => 'حقل العنوان بالعربية يجب ألا يتجاوز 255 حرفًا.',
            'title_en.string' => 'حقل العنوان بالإنجليزية يجب أن يكون نصًا.',
            'title_en.max' => 'حقل العنوان بالإنجليزية يجب ألا يتجاوز 255 حرفًا.',
            'image.image' => 'يجب أن يكون الملف المرفق صورة.',
            'image.mimes' => 'يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif.',
            'image.max' => 'يجب ألا تتجاوز الصورة 2 ميجابايت.',
            'code.unique' => 'كود الكوبون مستخدم بالفعل.',
            'discount_value.numeric' => 'قيمة الخصم يجب أن تكون رقمًا.',
            'discount_value.min' => 'قيمة الخصم يجب أن تكون أكبر من أو تساوي الصفر.',
            'start_date.date' => 'تاريخ البداية يجب أن يكون تاريخًا صالحًا.',
            'end_date.date' => 'تاريخ النهاية يجب أن يكون تاريخًا صالحًا.',
            'end_date.after_or_equal' => 'تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية.',
            'is_active.boolean' => 'حقل الحالة يجب أن يكون قيمة منطقية (true/false).',
            'organization_id.exists' => 'المنظمة المحددة غير موجودة.',
            'category_id.exists' => 'الفئة المحددة غير موجودة.',
        ];
    }
}
