<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAffiliateService extends FormRequest
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
            'title_ar' => 'required|string|max:150',
            'title_en' => 'required|string|max:150',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'features_ar' => 'required|json',
            'features_en' => 'required|json',
            'image' => 'required',
            'discount_percent' => 'required',
            'icon' => 'nullable',
            'status' => 'required',
            'confirmation_price' => 'required|numeric|min:0',
            'confirmation_status' => 'required',
            'organization_id' => 'required|exists:organizations,id',
            'category_id' => 'required|exists:service_categories,id',
        ];
    }


    /**
     * رسائل الأخطاء المخصصة.
     */
    public function messages(): array
    {
        return [
            'title_ar.required' => [
                'AR' => 'العنوان بالعربية مطلوب.',
                'EN' => 'The Arabic title is required.',
            ],
            'discount_percent.required' => [
                'AR' => ' نسبة الخصم للخدمة مطلوبة.',
                'EN' => 'The Discount Percent is  required.',
            ],
            'title_ar.string' => [
                'AR' => 'العنوان بالعربية يجب أن يكون نصًا.',
                'EN' => 'The Arabic title must be a string.',
            ],
            'title_ar.max' => [
                'AR' => 'العنوان بالعربية يجب ألا يتجاوز 150 حرفًا.',
                'EN' => 'The Arabic title must not exceed 150 characters.',
            ],

            'title_en.required' => [
                'AR' => 'العنوان بالإنجليزية مطلوب.',
                'EN' => 'The English title is required.',
            ],
            'title_en.string' => [
                'AR' => 'العنوان بالإنجليزية يجب أن يكون نصًا.',
                'EN' => 'The English title must be a string.',
            ],
            'title_en.max' => [
                'AR' => 'العنوان بالإنجليزية يجب ألا يتجاوز 150 حرفًا.',
                'EN' => 'The English title must not exceed 150 characters.',
            ],

            'description_ar.required' => [
                'AR' => 'الوصف بالعربية مطلوب.',
                'EN' => 'The Arabic description is required.',
            ],
            'description_ar.string' => [
                'AR' => 'الوصف بالعربية يجب أن يكون نصًا.',
                'EN' => 'The Arabic description must be a string.',
            ],

            'description_en.required' => [
                'AR' => 'الوصف بالإنجليزية مطلوب.',
                'EN' => 'The English description is required.',
            ],
            'description_en.string' => [
                'AR' => 'الوصف بالإنجليزية يجب أن يكون نصًا.',
                'EN' => 'The English description must be a string.',
            ],

            'features_ar.required' => [
                'AR' => 'المميزات بالعربية مطلوبة.',
                'EN' => 'The Arabic features are required.',
            ],
            'features_ar.json' => [
                'AR' => 'المميزات بالعربية يجب أن تكون بتنسيق JSON.',
                'EN' => 'The Arabic features must be in JSON format.',
            ],

            'features_en.required' => [
                'AR' => 'المميزات بالإنجليزية مطلوبة.',
                'EN' => 'The English features are required.',
            ],
            'features_en.json' => [
                'AR' => 'المميزات بالإنجليزية يجب أن تكون بتنسيق JSON.',
                'EN' => 'The English features must be in JSON format.',
            ],

            'image.required' => [
                'AR' => 'الصورة مطلوبة.',
                'EN' => 'The image is required.',
            ],

            'icon.nullable' => [
                'AR' => 'الأيقونة اختيارية.',
                'EN' => 'The icon is optional.',
            ],

            'status.required' => [
                'AR' => 'الحالة مطلوبة.',
                'EN' => 'The status is required.',
            ],
            'status.in' => [
                'AR' => 'الحالة يجب أن تكون إما "نشط" أو "غير نشط".',
                'EN' => 'The status must be either "active" or "inactive".',
            ],

            'confirmation_price.required' => [
                'AR' => 'سعر التأكيد مطلوب.',
                'EN' => 'The confirmation price is required.',
            ],
            'confirmation_price.numeric' => [
                'AR' => 'سعر التأكيد يجب أن يكون رقمًا.',
                'EN' => 'The confirmation price must be a number.',
            ],
            'confirmation_price.min' => [
                'AR' => 'سعر التأكيد يجب أن يكون أكبر من أو يساوي 0.',
                'EN' => 'The confirmation price must be greater than or equal to 0.',
            ],

            'confirmation_status.required' => [
                'AR' => 'حالة التأكيد مطلوبة.',
                'EN' => 'The confirmation status is required.',
            ],

            'organization_id.required' => [
                'AR' => 'معرف المنظمة مطلوب.',
                'EN' => 'The organization ID is required.',
            ],
            'organization_id.exists' => [
                'AR' => 'معرف المنظمة المحدد غير صالح.',
                'EN' => 'The selected organization ID is invalid.',
            ],

            'category_id.required' => [
                'AR' => 'معرف القسم مطلوب.',
                'EN' => 'The category ID is required.',
            ],
            'category_id.exists' => [
                'AR' => 'معرف القسم المحدد غير صالح.',
                'EN' => 'The selected category ID is invalid.',
            ],
        ];
    }
}
