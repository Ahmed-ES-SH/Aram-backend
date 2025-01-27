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
            'features_ar' => 'required|json', // يجب أن يكون النص JSON صالحًا
            'features_en' => 'required|json', // يجب أن يكون النص JSON صالحًا
            'duration' => 'required|string|max:255',
            'image' => 'required|file|image', // تأكد أن البيانات هي مسار أو رابط الصورة
            'price_before_discount' => 'required|string',
            'price' => 'required|string',
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
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'features.required' => 'The features field must contain valid JSON.',
            'duration.required' => 'The duration field is required.',
            'image.required' => 'The image field is required.',
        ];
    }
}
