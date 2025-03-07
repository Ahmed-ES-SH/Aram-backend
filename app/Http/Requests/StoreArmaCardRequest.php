<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArmaCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'user_id'       => 'required|exists:users,id', // يجب أن يكون معرف المستخدم موجودًا في جدول المستخدمين
            'card_number'   => 'required|string|unique:cards,card_number', // رقم البطاقة يجب أن يكون فريدًا
            'card_type'     => 'required|string|in:gold,silver,regular', // نوع البطاقة
            'price'         => 'required|numeric|min:0', // السعر يجب أن يكون رقمًا غير سالب
            'issue_date'    => 'required|date|before_or_equal:today', // تاريخ الإصدار يجب أن يكون اليوم أو قبل
            'expiry_date'   => 'nullable|date|after:issue_date', // تاريخ الانتهاء اختياري ولكنه يجب أن يكون بعد تاريخ الإصدار
            'status'        => 'required|string|in:active,inactive,expired', // الحالة يجب أن تكون واحدة من الخيارات المحددة
            'usage_limit'   => 'nullable|integer|min:1', // عدد مرات الاستخدام المسموح بها
        ];
    }

    public function messages()
    {
        return [
            'user_id.required'      => 'معرف المستخدم مطلوب.',
            'user_id.exists'        => 'المستخدم المحدد غير موجود.',
            'card_number.required'  => 'رقم البطاقة مطلوب.',
            'card_number.unique'    => 'رقم البطاقة مستخدم مسبقًا.',
            'card_type.required'    => 'نوع البطاقة مطلوب.',
            'card_type.in'          => 'نوع البطاقة يجب أن يكون "gold", "silver" أو "regular".',
            'price.required'        => 'السعر مطلوب.',
            'price.numeric'         => 'السعر يجب أن يكون رقمًا صحيحًا.',
            'issue_date.required'   => 'تاريخ الإصدار مطلوب.',
            'issue_date.date'       => 'تاريخ الإصدار يجب أن يكون تاريخًا صحيحًا.',
            'expiry_date.after'     => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ الإصدار.',
        ];
    }
}
