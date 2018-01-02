<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'username'  => 'required|string|max:20|unique:users',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6|',
            'name'      => 'required|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '姓名 不能为空。',
            'name.max' => '姓名 最多为 20 个字符。',
        ];
    }
}
