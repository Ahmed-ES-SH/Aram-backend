<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest extends FormRequest
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
            'title_ar' => 'sometimes|string|max:255',
            'title_en' => 'sometimes|string|max:255',
            'description_ar' => 'sometimes|string',
            'description_en' => 'sometimes|string',
            'features' => 'nullable|string|nullable',
            'accaptable_message' => 'string|nullable',
            'unaccaptable_message' => 'string|nullable',
            'confirmation_status' => 'string|nullable',
            'confirmation_price' => 'string|nullable',
            'location' => 'sometimes|string|max:500',
            'categories_ids' => 'required', // التأكد من أن الفئة موجودة
            'phone_number' => 'sometimes|string|max:15|regex:/^[0-9+\-\s]+$/', // قبول أرقام الهواتف فقط
            'url' => 'nullable|url', // التأكد من صحة الرابط إذا وُجد
            'image' => 'nullable', // التأكد من أن الملف صورة
            'confirmation_price' => 'nullable', // التأكد من أن الملف صورة
            'icon' => 'nullable', // التأكد من أن الملف أيقونة
            'account_type' => 'nullable',
            'is_signed' => 'nullable',
            'number_of_reservations' => 'nullable',
            'open_at' => 'nullable',
            'booking_status' => 'nullable', //
            'close_at' => 'nullable',
            'status' => 'sometimes|in:published,not_published,under_review'
        ];
    }


    /**
     * تخصيص رسائل الأخطاء.
     * @return array
     */
    public function messages(): array
    {
        return [
            'category_id.exists' => 'الفئة المختارة غير موجودة.',
            'categories_ids.required' => 'لا بد من تحديد قسم واحد للمركز على الأقل .',
            'features.required' => 'أضف بعض المميزات الى المركز .',
            'phone_number.regex' => 'صيغة رقم الهاتف غير صحيحة.',
            'url.url' => 'الرابط يجب أن يكون صالحًا.',
            'image.image' => 'يجب أن يكون الملف صورة.',
            'image.mimes' => 'يجب أن تكون الصورة بامتداد jpeg, png, jpg, أو gif.',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميغابايت.',
            'icon.image' => 'يجب أن يكون الملف أيقونة صورة.',
            'icon.mimes' => 'يجب أن تكون الأيقونة بامتداد jpeg, png, jpg, أو gif.',
            'icon.max' => 'حجم الأيقونة يجب ألا يتجاوز 1 ميغابايت.',
        ];
    }
}
