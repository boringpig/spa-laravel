<?php

namespace App\Http\Requests\AreaGroup;

use Illuminate\Foundation\Http\FormRequest;

class CreateAreaGroupRequest extends FormRequest
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
            'parent_area' => 'required|string|numeric|unique:area_groups',
            'child_area'  => 'required|array',
        ];
    }

    public function attributes()
    {
        return [
            'parent_area'     => '地区',
            'child_area'      => '群组',
        ];
    }
}
