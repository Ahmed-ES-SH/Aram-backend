<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'article_id' => 'required|exists:blogs,id', // يجب أن يكون معرف المقالة موجودًا
            'user_id' => 'required',       // يجب أن يكون معرف المستخدم موجودًا
            'user_type' => 'required|string',       // يجب أن يكون معرف المستخدم موجودًا
            'content' => 'required|string|max:1000',      // النص مطلوب ويجب ألا يتجاوز 1000 حرف
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
            'article_id.required' => 'يرجى تحديد المقالة المرتبطة بالتعليق.',
            'article_id.exists' => 'المقالة المحددة غير موجودة.',
            'user_id.required' => 'يرجى تحديد المستخدم صاحب التعليق.',
            'user_id.exists' => 'المستخدم المحدد غير موجود.',
            'content.required' => 'يرجى إدخال نص التعليق.',
            'content.string' => 'نص التعليق يجب أن يكون نصاً صالحاً.',
            'content.max' => 'نص التعليق يجب ألا يتجاوز 1000 حرف.',
        ];
    }
}
