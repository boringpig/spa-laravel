<?php

namespace App\Http\Requests\AreaGroup;

use Illuminate\Foundation\Http\FormRequest;
use App\Entities\AreaGroup;

class EditAreaGroupRequest extends FormRequest
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
            'parent_area' => 'required|string|numeric|unique:area_groups',
            'child_area'  => 'required|array',
        ];
        $group = AreaGroup::find($_REQUEST['id']);
		if ($_REQUEST['parent_area'] === $group->parent_area){
			$rules['parent_area'] = 'required|string|numeric';
        }
        
        return $rules;
    }

    public function attributes()
    {
        return [
            'parent_area'     => '地区',
            'child_area'      => '群组',
        ];
    }
}
