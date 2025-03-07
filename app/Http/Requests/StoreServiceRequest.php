<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg,ico', // التحقق من ملف الصورة
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg,ico', // التحقق من صورة الخدمة
            'features' => 'string|nullable',
            'popularity' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
            'tags' => 'nullable',
            'tags.*' => 'string|max:50', // كل كلمة دلالية عبارة عن نص أقصى طوله 50
            'video_url' => 'nullable|url', // التحقق من رابط الفيديو
            'category_id' => 'required|exists:service_categories,id', // التحقق من وجود التصنيف
            'organization_ids' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'title_en.required' => 'The English title is required.',
            'title_ar.required' => 'The Arabic title is required.',
            'description_ar.required' => 'The Arabic description is required.',
            'description_en.required' => 'The English description is required.',
            'icon.image' => 'The icon must be a valid image file.',
            'image.image' => 'The service image must be a valid image file.',
            'video_url.url' => 'The video URL must be a valid URL.',
            'category_id.required' => 'The category is required.',
            'category_id.exists' => 'The selected category does not exist.',
            'features.string' => 'The Features Must be String',
        ];
    }
}
