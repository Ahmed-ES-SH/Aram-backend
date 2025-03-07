<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessage extends FormRequest
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
            'message_type' => 'required|in:text,image,audio',
            'sender_id' => 'required|integer',
            'sender_type' => 'required|in:User,Organization',
            'content' => 'nullable|string',
            'file_path' => 'nullable|file|max:20000',
        ];
    }
}
