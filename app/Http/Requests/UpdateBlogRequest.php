<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
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
            'title_ar' => 'sometimes|string|max:255',
            'title_en' => 'sometimes|string|max:255',
            'content_ar' => 'sometimes|string',
            'content_en' => 'sometimes|string',
            'likes' => 'sometimes',
            'dislikes' => 'sometimes',
            'hearts' => 'sometimes',
            'laughs' => 'sometimes',
            'author_id' => 'sometimes|exists:users,id', // يجب أن يكون معرف الكاتب موجودًا في جدول المستخدمين
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
            'title_ar.max' => 'عنوان المقالة باللغة العربية يجب ألا يتجاوز 255 حرفاً.',
            'title_en.max' => 'عنوان المقالة باللغة الإنجليزية يجب ألا يتجاوز 255 حرفاً.',
            'author_id.exists' => 'معرف الكاتب غير موجود في النظام.',
            'published_at.date' => 'تاريخ النشر يجب أن يكون بصيغة تاريخ صحيحة.',
        ];
    }
}
