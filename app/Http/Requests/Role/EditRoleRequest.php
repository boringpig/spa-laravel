<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use App\Entities\Role;

class EditRoleRequest extends FormRequest
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
        $rules = [
            'name'              => 'required|string|max:20|unique:roles',
            'permission'        => 'required',
            'area_permission'   => 'required',
        ];

        $role = Role::find($_REQUEST['id']);
        if($_REQUEST['name'] === $role->name) {
            $rules['name'] = 'required|string|max:20';
        }

        return $rules;
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
