<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password'               => 'required|string|min:6|same:password_confirmation',
            'password_confirmation'  => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'password_confirmation.requried' => '确认密码 不能為空。',
            'password_confirmation.min' => '确认密码 至少为 6 个字符。',
        ];
    }
}
