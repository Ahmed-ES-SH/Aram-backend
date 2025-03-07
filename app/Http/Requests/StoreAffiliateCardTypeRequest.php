<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAffiliateCardTypeRequest extends FormRequest
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
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'organization_id' => 'required|numeric|exists:organizations,id',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'price_before_discount' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'features_ar' => 'nullable|string',
            'features_en' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'active' => 'required|boolean',
            'status' => 'required|string|in:allow,not_allow,under_review',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title_en.required' => __('The English title is required.|العنوان باللغة الإنجليزية مطلوب.'),
            'title_en.string' => __('The English title must be a string.|العنوان باللغة الإنجليزية يجب أن يكون نصاً.'),
            'title_en.max' => __('The English title may not be greater than 255 characters.|العنوان باللغة الإنجليزية يجب ألا يزيد عن 255 حرفاً.'),

            'title_ar.required' => __('The Arabic title is required.|العنوان باللغة العربية مطلوب.'),
            'title_ar.string' => __('The Arabic title must be a string.|العنوان باللغة العربية يجب أن يكون نصاً.'),
            'title_ar.max' => __('The Arabic title may not be greater than 255 characters.|العنوان باللغة العربية يجب ألا يزيد عن 255 حرفاً.'),

            'description_en.required' => __('The English description is required.|الوصف باللغة الإنجليزية مطلوب.'),
            'description_en.string' => __('The English description must be a string.|الوصف باللغة الإنجليزية يجب أن يكون نصاً.'),

            'description_ar.required' => __('The Arabic description is required.|الوصف باللغة العربية مطلوب.'),
            'description_ar.string' => __('The Arabic description must be a string.|الوصف باللغة العربية يجب أن يكون نصاً.'),

            'price_before_discount.numeric' => __('The price before discount must be a number.|السعر قبل الخصم يجب أن يكون رقماً.'),
            'price_before_discount.min' => __('The price before discount must be at least 0.|السعر قبل الخصم يجب أن يكون على الأقل 0.'),

            'price.required' => __('The price is required.|السعر مطلوب.'),
            'price.numeric' => __('The price must be a number.|السعر يجب أن يكون رقماً.'),
            'price.min' => __('The price must be at least 0.|السعر يجب أن يكون على الأقل 0.'),

            'features_ar.string' => __('The Arabic features must be a string.|المميزات باللغة العربية يجب أن تكون نصاً.'),
            'features_en.string' => __('The English features must be a string.|المميزات باللغة الإنجليزية يجب أن تكون نصاً.'),

            'duration.required' => __('The duration is required.|المدة مطلوبة.'),
            'duration.integer' => __('The duration must be an integer.|المدة يجب أن تكون عدداً صحيحاً.'),
            'duration.min' => __('The duration must be at least 1.|المدة يجب أن تكون على الأقل 1.'),

            'image.image' => __('The image must be a valid image file.|الصورة يجب أن تكون ملف صورة صحيح.'),
            'image.mimes' => __('The image must be of type: jpeg, png, jpg, gif.|الصورة يجب أن تكون من نوع: jpeg, png, jpg, gif.'),
            'image.max' => __('The image may not be greater than 2048 kilobytes.|الصورة يجب ألا تزيد عن 2048 كيلوبايت.'),

            'active.required' => __('The active status is required.|حالة النشاط مطلوبة.'),
            'active.boolean' => __('The active status must be true or false.|حالة النشاط يجب أن تكون إما true أو false.'),

            'status.required' => __('The status is required.|الحالة مطلوبة.'),
            'status.string' => __('The status must be a string.|الحالة يجب أن تكون نصاً.'),
            'status.in' => __('The status must be either available or unavailable.|الحالة يجب أن تكون إما متاحة أو غير متاحة.'),
        ];
    }
}
