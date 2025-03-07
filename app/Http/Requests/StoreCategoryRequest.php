<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'title_en' => 'required|string|max:200',
            'title_ar' => 'required|string|max:200',
            'image' => 'required|file|image'
        ];
    }

    public function messages()
    {
        return [
            'image.image' => 'يرجى التأكد من ان الملف عبارة عن صورة .',
            'image.required' => 'يرجى التأكد من رفع صورة .',
            'image.mimes' => 'الصورة يجب أن تكون بصيغة JPG, JPEG, أو PNG.',
            'title.max' => 'العنوان يجب ان يكون نص صالح لا يتجاوز 200 حرف.',
            'title.string' => 'العنوان يجب ان يكون نص صالح.',
            'title.required' => 'النص الثاني يجب أن يكون نصاً صالحاً.',
        ];
    }
}
