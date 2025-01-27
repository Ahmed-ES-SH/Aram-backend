<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyDetailesRequest extends FormRequest
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
            'whatsapp_number'   => 'sometimes|string|max:255',
            'gmail_account'     => 'sometimes|email|max:255',
            'facebook_account'     => 'sometimes|max:255',
            'x_account'     => 'sometimes|max:255',
            'youtube_account'     => 'sometimes|max:255',
            'instgram_account'     => 'sometimes|max:255',
            'snapchat_account'     => 'sometimes|max:255',
            'about_ar'   => 'sometimes|string',
            'about_en'   => 'sometimes|string',
            'vision_ar'         => 'sometimes|string',
            'vision_en'         => 'sometimes|string',
            'goals_ar'          => 'sometimes|string',
            'goals_en'          => 'sometimes|string',
            'values_ar'         => 'sometimes|string',
            'values_en'         => 'sometimes|string',
            'show_map'          => 'sometimes|string',
            'address'           => 'nullable|string|max:255',
            'about_image'       => 'nullable',
            'vision_image'      => 'nullable',
            'goals_image'       => 'nullable',
            'values_image'      => 'nullable',
            'main_video'        => 'nullable',
        ];
    }

    /**
     * تخصيص الرسائل الخاصة بالأخطاء.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'address.string'           => 'العنوان يجب أن يكون نصًا',
            'address.max'              => 'العنوان يجب ألا يتجاوز 255 حرفًا',
            'about_image.image'        => 'صورة "عن الشركة" يجب أن تكون من نوع صورة',
            'about_image.mimes'        => 'صورة "عن الشركة" يجب أن تكون بصيغة jpeg، png، jpg، gif أو svg',
            'about_image.max'          => 'حجم صورة "عن الشركة" يجب ألا يتجاوز 2 ميجابايت',
            'vision_image.image'       => 'صورة الرؤية يجب أن تكون من نوع صورة',
            'vision_image.mimes'       => 'صورة الرؤية يجب أن تكون بصيغة jpeg، png، jpg، gif أو svg',
            'vision_image.max'         => 'حجم صورة الرؤية يجب ألا يتجاوز 2 ميجابايت',
            'goals_image.image'        => 'صورة الأهداف يجب أن تكون من نوع صورة',
            'goals_image.mimes'        => 'صورة الأهداف يجب أن تكون بصيغة jpeg، png، jpg، gif أو svg',
            'goals_image.max'          => 'حجم صورة الأهداف يجب ألا يتجاوز 2 ميجابايت',
            'values_image.image'       => 'صورة القيم يجب أن تكون من نوع صورة',
            'values_image.mimes'       => 'صورة القيم يجب أن تكون بصيغة jpeg، png، jpg، gif أو svg',
            'values_image.max'         => 'حجم صورة القيم يجب ألا يتجاوز 2 ميجابايت',
            'main_video.url'           => 'الرابط الخاص بالفيديو يجب أن يكون رابطًا صالحًا',
        ];
    }
}
