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
            'role_id'   => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'username'      => '帐号',
            'name'          => '姓名',
            'email'         => '信箱',
            'role_id'       => '角色权限',
        ];
    }
}
