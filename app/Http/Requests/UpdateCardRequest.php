<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCardRequest extends FormRequest
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
    public function rules()
    {
        return [
            'card_number'   => 'nullable|string|unique:cards,card_number,' . $this->card, // يجب أن يكون فريدًا إلا إذا كان نفس البطاقة الحالية
            'card_type'     => 'nullable|string', // حدد القيم المسموح بها لأنواع البطاقات
            'price'         => 'nullable|numeric|min:0', // يجب أن يكون رقمًا غير سالب
            'issue_date'    => 'nullable|date|before_or_equal:today', // يجب أن يكون تاريخًا صحيحًا ولا يمكن أن يكون في المستقبل
            'expiry_date'   => 'nullable|date|after:issue_date', // إذا كان محددًا، يجب أن يكون بعد تاريخ الإصدار
            'status'        => 'nullable|string|in:active,inactive,expired', // القيم المسموح بها
            'usage_limit'   => 'nullable|integer|min:1', // عدد الاستخدامات المسموح بها
            'current_usage' => 'nullable|integer|min:0|max:usage_limit', // عدد الاستخدامات الحالية
        ];
    }

    /**
     * تخصيص رسائل الخطأ.
     */
    public function messages()
    {
        return [
            'card_number.unique' => 'رقم البطاقة مستخدم مسبقًا.',
            'card_type.in'       => 'نوع البطاقة يجب أن يكون "gold", "silver" أو "regular".',
            'price.numeric'      => 'السعر يجب أن يكون رقمًا صحيحًا.',
            'issue_date.date'    => 'تاريخ الإصدار يجب أن يكون تاريخًا صحيحًا.',
            'expiry_date.after'  => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ الإصدار.',
        ];
    }
}
