<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'book_day' => 'sometimes|date',
            'book_time' => 'sometimes|date_format:H:i',
            'additional_notes' => 'sometimes|string',
            'user_id' => 'sometimes|exists:users,id',
            'organization_id' => 'sometimes|exists:organizations,id',
        ];
    }
}
