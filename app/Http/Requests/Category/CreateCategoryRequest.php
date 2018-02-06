<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'no'    => 'required|string|numeric|unique:categories',
            'name'  => 'required|string|unique:categories',
        ];
    }

    public function attributes()
    {
        return [
            'no'        => '标题编号',
            'name'      => '标题名称',
        ];
    }
}
