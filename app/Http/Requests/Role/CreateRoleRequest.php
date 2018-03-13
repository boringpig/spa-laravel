<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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
            'name'              => 'required|string|max:20|unique:roles',
            'permission'        => 'required',
            'area_permission'   => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name'              => '',
            'permission'        => '',
            'area_permission'   => '',
        ];
    }
}
