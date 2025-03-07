<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'slug' => 'nullable|string|max:255',
            'category_id' => 'nullable',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'required|string',
            'author_id' => 'required|exists:users,id', // يجب أن يكون معرف الكاتب موجودًا في جدول المستخدمين
            'published_at' => 'nullable|date', // تحقق من صحة تاريخ النشر إذا تم توفيره
        ];
    }

    /**
     * الرسائل المخصصة لأخطاء التحقق.
     *
     * @return array
     */

    public function messages()
    {
        return [
            // 'slug.required' => 'يرجى إدخال الرابط المختصر للمقالة.',
            'slug.unique' => 'الرابط المختصر مستخدم مسبقاً، يرجى اختيار رابط مختلف.',
            'slug.max' => 'الرابط المختصر يجب ألا يتجاوز 255 حرفاً.',
            'category.required' => 'يرجى إدخال قسم المقالة .',
            'title_ar.required' => 'يرجى إدخال عنوان المقالة باللغة العربية.',
            'title_ar.max' => 'عنوان المقالة باللغة العربية يجب ألا يتجاوز 255 حرفاً.',
            'title_en.required' => 'يرجى إدخال عنوان المقالة باللغة الإنجليزية.',
            'title_en.max' => 'عنوان المقالة باللغة الإنجليزية يجب ألا يتجاوز 255 حرفاً.',
            'content_ar.required' => 'يرجى إدخال محتوى المقالة باللغة العربية.',
            'content_en.required' => 'يرجى إدخال محتوى المقالة باللغة الإنجليزية.',
            'author_id.required' => 'يرجى تحديد كاتب المقالة.',
            'author_id.exists' => 'معرف الكاتب غير موجود في النظام.',
            'published_at.date' => 'تاريخ النشر يجب أن يكون بصيغة تاريخ صحيحة.',
        ];
    }
}
