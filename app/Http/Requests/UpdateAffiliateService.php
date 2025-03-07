<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAffiliateService extends FormRequest
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
            'title_ar' => 'sometimes|string|max:255',
            'title_en' => 'sometimes|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'features_ar' => 'sometimes',
            'features_en' => 'sometimes',
            'image' => 'sometimes',
            'icon' => 'sometimes',
            'discount_percent' => 'sometimes',
            'status' => 'sometimes',
            'check_status' => 'sometimes',
            'confirmation_price' => 'sometimes|numeric|min:0',
            'confirmation_status' => 'nullable',
            'number_of_orders' => 'sometimes|integer|min:0',
            'organization_id' => 'sometimes|exists:organizations,id',
            'category_id' => 'sometimes|exists:service_categories,id',
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
            'status.in' => 'الحالة يجب أن تكون إما active أو inactive.',
            'confirmation_price.numeric' => 'سعر التأكيد يجب أن يكون رقمًا.',
            'number_of_orders.integer' => 'عدد الطلبات يجب أن يكون رقمًا صحيحًا.',
            'organization_id.exists' => 'المنظمة المحددة غير موجودة.',
            'category_id.exists' => 'الفئة المحددة غير موجودة.',
        ];
    }
}
