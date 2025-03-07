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
            'description_ar' => 'required|string', // الوصف بالعربية (اختياري)
            'description_en' => 'required|string', // الوصف بالإنجليزية (اختياري)
            'code' => 'nullable|string|unique:offers,code', // كود الكوبون (فريد إذا كان موجوداً)
            'usage_limit' => 'nullable|integer',
            'discount_value' => 'required|numeric|min:0', // قيمة الخصم (مطلوب، رقم موجب)
            'start_date' => 'required|date', // تاريخ البداية (مطلوب، تاريخ صالح)
            'end_date' => 'required|date|after_or_equal:start_date', // تاريخ النهاية (مطلوب، بعد أو يساوي تاريخ البداية)
            'is_active' => 'sometimes|boolean', // حالة العرض (اختياري، قيمة منطقية)
            'status' => 'string|in:waiting,expired,active', // حالة العرض (اختياري، قيمة منطقية)
            'card_type_id' => 'nullable',
          	'organization_id' => 'nullable', // معرف المنظمة (مطلوب، موجود في جدول المنظمات)
            'category_id' => 'required|exists:service_categories,id', // معرف الفئة (مطلوب، موجود في جدول الفئات)
        ];
    }


    /**
     * رسائل الأخطاء المخصصة.
     */
    public function messages(): array
    {
        return [
            'title_ar.required' => ['AR' => "حقل العنوان بالعربية مطلوب", "EN" => "The Arabic title field is required."],
            'title_en.required' => ['AR' => "حقل العنوان بالإنجليزية مطلوب", "EN" => "The English title field is required."],
            'description_ar.required' => ['AR' => "حقل الوصف بالعربية مطلوب", "EN" => "The Arabic description field is required."],
            'description_en.required' => ['AR' => "حقل الوصف بالإنجليزية مطلوب", "EN" => "The English description field is required."],
            'image.image' => ['AR' => "يجب أن يكون الملف المرفق صورة.", "EN" => "The uploaded file must be an image."],
            'image.mimes' => ['AR' => "يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif.", "EN" => "The image must be of type: jpeg, png, jpg, gif."],
            'image.max' => ['AR' => "يجب ألا تتجاوز الصورة 2 ميجابايت.", "EN" => "The image must not exceed 2MB."],
            'code.unique' => ['AR' => "كود الكوبون مستخدم بالفعل.", "EN" => "The coupon code is already in use."],
            'discount_value.required' => ['AR' => "حقل قيمة الخصم مطلوب.", "EN" => "The discount value field is required."],
            'discount_value.numeric' => ['AR' => "قيمة الخصم يجب أن تكون رقمًا.", "EN" => "The discount value must be a number."],
            'discount_value.min' => ['AR' => "قيمة الخصم يجب أن تكون أكبر من أو تساوي الصفر.", "EN" => "The discount value must be greater than or equal to zero."],
            'start_date.required' => ['AR' => "حقل تاريخ البداية مطلوب.", "EN" => "The start date field is required."],
            'start_date.date' => ['AR' => "تاريخ البداية يجب أن يكون تاريخًا صالحًا.", "EN" => "The start date must be a valid date."],
            'end_date.required' => ['AR' => "حقل تاريخ النهاية مطلوب.", "EN" => "The end date field is required."],
            'end_date.date' => ['AR' => "تاريخ النهاية يجب أن يكون تاريخًا صالحًا.", "EN" => "The end date must be a valid date."],
            'end_date.after_or_equal' => ['AR' => "تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية.", "EN" => "The end date must be after or equal to the start date."],
            'is_active.boolean' => ['AR' => "حقل الحالة يجب أن يكون قيمة منطقية (true/false).", "EN" => "The status field must be a boolean value (true/false)."],
            'organization_id.required' => ['AR' => "حقل معرف المنظمة مطلوب.", "EN" => "The organization ID field is required."],
            'organization_id.exists' => ['AR' => "المنظمة المحددة غير موجودة.", "EN" => "The selected organization does not exist."],
            'category_id.required' => ['AR' => "حقل معرف الفئة مطلوب.", "EN" => "The category ID field is required."],
            'category_id.exists' => ['AR' => "الفئة المحددة غير موجودة.", "EN" => "The selected category does not exist."],
        ];
    }
}
