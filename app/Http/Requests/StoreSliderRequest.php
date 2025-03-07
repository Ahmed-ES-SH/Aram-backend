<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
{
    /**
     * تحديد ما إذا كان يمكن للمستخدم إجراء هذا الطلب.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // أو تحقق حسب متطلبات الأمان
    }

    /**
     * قواعد التوثيق للبيانات المدخلة.
     *
     * @return array
     */
    public function rules()
    {
        // dd($this->all());

        return [
            'image' => 'sometimes|file|image|mimes:jpg,jpeg,png,svg',
            'bg_color' => 'nullable|string|max:7|regex:/^#[A-Fa-f0-9]{6}$/',  // اللون يمكن أن يكون على شكل نص ويجب أن يحتوي على 7 أحرف (رمز الهاش)
            'text_1_ar' => 'nullable|string|max:255',  // النص الأول، لا يزيد عن 255 حرفاً
            'text_1_en' => 'nullable|string|max:255',  // النص الأول، لا يزيد عن 255 حرفاً
            'text_2_ar' => 'nullable|string|max:255',  // النص الثاني، لا يزيد عن 255 حرفاً
            'text_2_en' => 'nullable|string|max:255',  // النص الثاني، لا يزيد عن 255 حرفاً
            'text_3_ar' => 'nullable|string|max:255',  // النص الثالث، لا يزيد عن 255 حرفاً
            'text_3_en' => 'nullable|string|max:255',  // النص الثالث، لا يزيد عن 255 حرفاً
        ];
    }


    /**
     * الرسائل المخصصة لأخطاء التوثيق.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'image.image' => 'يرجى التأكد من ان الملف عبارة عن صورة .',
            'image.mimes' => 'الصورة يجب أن تكون بصيغة JPG, JPEG, أو PNG.',
            'bg_color.string' => 'اللون الخلفي يجب أن يكون نصاً ولا يزيد عن 7 أحرف.',
            'bg_color.max' => 'اللون الخلفي يجب أن يحتوي على 7 أحرف كحد أقصى.',
            'text_1_ar.string' => 'النص الأول يجب أن يكون نصاً صالحاً.',
            'text_1_ar.max' => 'النص الأول لا يجب أن يتجاوز 255 حرفاً.',
            'text_2_ar.string' => 'النص الثاني يجب أن يكون نصاً صالحاً.',
            'text_2_ar.max' => 'النص الثاني لا يجب أن يتجاوز 255 حرفاً.',
            'text_3_ar.string' => 'النص الثالث يجب أن يكون نصاً صالحاً.',
            'text_3_ar.max' => 'النص الثالث لا يجب أن يتجاوز 255 حرفاً.',
            'text_1_en.string' => 'النص الأول يجب أن يكون نصاً صالحاً.',
            'text_1_en.max' => 'النص الأول لا يجب أن يتجاوز 255 حرفاً.',
            'text_2_en.string' => 'النص الثاني يجب أن يكون نصاً صالحاً.',
            'text_2_en.max' => 'النص الثاني لا يجب أن يتجاوز 255 حرفاً.',
            'text_3_en.string' => 'النص الثالث يجب أن يكون نصاً صالحاً.',
            'text_3_en.max' => 'النص الثالث لا يجب أن يتجاوز 255 حرفاً.',
        ];
    }
}
