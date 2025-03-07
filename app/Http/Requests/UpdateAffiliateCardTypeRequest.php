<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAffiliateCardTypeRequest extends FormRequest
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
            'title_en' => 'sometimes|string|max:255',
            'title_ar' => 'sometimes|string|max:255',
            'description_en' => 'sometimes|string',
            'description_ar' => 'sometimes|string',
            'price_before_discount' => 'nullable|numeric|min:0',
            'price' => 'sometimes|numeric|min:0',
            'features_ar' => 'nullable|string',
            'features_en' => 'nullable|string',
            'duration' => 'sometimes|integer|min:1',
            'image' => 'nullable',
            'active' => 'sometimes|boolean',
            'status' => 'sometimes|string|in:allow,not_allow,under_review',
        ];
    }
}
