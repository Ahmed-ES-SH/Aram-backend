<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'book_day' => 'required|date',
            'book_time' => 'required',
            'expire_in' => 'required',
            'additional_notes' => 'nullable|string',
            'user_id' => 'nullable',
            'organization_id' => 'required|exists:organizations,id',
        ];
    }



    public function messages()
    {
        return [
            'book_day.required' => 'يرجى تحديد تاريخ الحجز.',
            'book_day.date' => 'التاريخ المدخل غير صالح.',
            'book_time.required' => 'يرجى تحديد وقت الحجز.',
            'book_time.date_format' => 'يجب أن يكون وقت الحجز بتنسيق HH:MM.',
            'additional_notes.string' => 'الملاحظات يجب أن تكون نصًا.',
            'user_id.required' => 'يرجى تحديد المستخدم المرتبط.',
            'organization_id.required' => 'يرجى تحديد المستخدم المرتبط.',
            'user_id.exists' => 'المستخدم المحدد غير موجود.',
            'organization_id.exists' => 'المركز المحدد غير موجود.',
        ];
    }
}
