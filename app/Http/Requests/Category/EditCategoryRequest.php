<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use App\Entities\Category;

class EditCategoryRequest extends FormRequest
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
            'no'    => 'required|string|numeric|unique:categories',
            'name'  => 'required|string|unique:categories',
        ];

        $category = Category::find($_REQUEST['id']);
		if ($_REQUEST['no'] === $category->no){
			$rules['no'] = 'required|string|numeric';
		}
		if ($_REQUEST['name'] === $category->name){
			$rules['name'] = 'required|string';
		}

        return $rules;
    }

    public function attributes()
    {
        return [
            'no'        => '标题编号',
            'name'      => '标题名称',
        ];
    }
}
