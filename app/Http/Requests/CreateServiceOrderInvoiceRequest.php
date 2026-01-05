<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceOrderInvoiceRequest extends FormRequest
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
            'order_id' => 'required|exists:service_orders,id',
            'invoice_number' => 'required',
            'total_invoice' => 'required|numeric',
            'before_discount' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'ref_code' => 'nullable|exists:promoters,referral_code',
            'invoice_type' => 'required',
            'user_id' => 'required|integer',
            'tax_amount' => 'nullable|numeric',
            'user_type' => 'required|in:user,organization',
        ];
    }
}
