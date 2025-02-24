<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardTypeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // تعديل هذه الطريقة إذا كانت هناك صلاحيات محددة
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'features_ar' => 'required', // يجب أن يكون النص JSON صالحًا
            'features_en' => 'required', // يجب أن يكون النص JSON صالحًا
            'duration' => 'required|string|max:255',
            'image' => 'required|file|image', // تأكد أن البيانات هي مسار أو رابط الصورة
            'price_before_discount' => 'required',
            'price' => 'required',
            'category_id' => 'required|exists:card_type_categories,id',
            'active' => 'nullable|boolean'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title_ar.required' => 'عنوان البطاقة باللغة العربية مطلوب.',
            'title_ar.string' => 'عنوان البطاقة باللغة العربية يجب أن يكون نصًا.',
            'title_ar.max' => 'عنوان البطاقة باللغة العربية يجب ألا يتجاوز 255 حرفًا.',

            'title_en.required' => 'عنوان البطاقة باللغة الإنجليزية مطلوب.',
            'title_en.string' => 'عنوان البطاقة باللغة الإنجليزية يجب أن يكون نصًا.',
            'title_en.max' => 'عنوان البطاقة باللغة الإنجليزية يجب ألا يتجاوز 255 حرفًا.',

            'description_en.required' => 'الوصف باللغة الإنجليزية مطلوب.',
            'description_en.string' => 'الوصف باللغة الإنجليزية يجب أن يكون نصًا.',

            'description_ar.required' => 'الوصف باللغة العربية مطلوب.',
            'description_ar.string' => 'الوصف باللغة العربية يجب أن يكون نصًا.',

            'features_ar.required' => 'المميزات باللغة العربية مطلوبة.',

            'features_en.required' => 'المميزات باللغة الإنجليزية مطلوبة.',

            'duration.required' => 'مدة الاشتراك مطلوبة.',
            'duration.string' => 'مدة الاشتراك يجب أن تكون نصًا.',
            'duration.max' => 'مدة الاشتراك يجب ألا تتجاوز 255 حرفًا.',

            'image.required' => 'صورة البطاقة مطلوبة.',
            'image.file' => 'يجب أن يكون الملف صورة صالحة.',
            'image.image' => 'يجب أن يكون الملف صورة بتنسيق صحيح.',

            'price_before_discount.required' => 'السعر قبل الخصم مطلوب.',

            'price.required' => 'السعر مطلوب.',

            'category_id.required' => 'يجب تحديد الفئة.',
            'category_id.exists' => 'الفئة المحددة غير موجودة.',

            'active.boolean' => 'يجب أن تكون الحالة إما مفعلة أو غير مفعلة.',
        ];
    }
}
