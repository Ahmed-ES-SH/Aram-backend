<?php

namespace App\Modules\Service\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceOrderRequest extends FormRequest
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
            'files' => 'nullable',
            'files.*' => 'nullable|file|max:5096',
            'service_id' => 'required|exists:service_pages,id',
            'activity_id' => 'nullable|exists:promotion_activities,id',
            'invoice_type' => 'nullable|string',
            'metadata' => 'required|array',
        ];
    }



    public function prepareForValidation()
    {
        if ($this->has('metadata')) {
            $this->merge([
                'metadata' => json_decode($this->metadata, true),
            ]);
        }
    }
}
