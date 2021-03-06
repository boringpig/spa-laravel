<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class CreateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_service_phone'    => 'nullable',
            'customer_service_email'    => 'nullable',
            'kiosk_freetime'            => 'nullable|numeric|min:0',
        ];
    }

    public function attributes()
    {
        return [
            'customer_service_phone'      => '',
            'customer_service_email'      => '',
            'kiosk_freetime'              => '',
        ];
    }
}
