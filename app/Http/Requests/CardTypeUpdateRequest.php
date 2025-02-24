<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardTypeUpdateRequest extends FormRequest
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
            'title_ar' => 'sometimes|string|max:255',
            'title_en' => 'sometimes|string|max:255',
            'description_en' => 'sometimes|string',
            'description_ar' => 'sometimes|string',
            'features_ar' => 'sometimes', // يجب أن يكون النص JSON صالحًا
            'features_en' => 'sometimes', // يجب أن يكون النص JSON صالحًا
            'duration' => 'sometimes|string|max:255',
            'price_before_discount' => 'sometimes',
            'category_id' => 'sometimes|exists:card_type_categories,id',
            'price' => 'sometimes',
            'active' => 'sometimes',
            'quantity' => 'sometimes'
        ];
    }
}
