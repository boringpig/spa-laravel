<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class EditArticleRequest extends FormRequest
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
            'category_no'    => 'required|string',
            'content'        => 'required|string',
            'language'       => 'required|string|in:cn,tw,en',
            'broadcast_area' => 'required|array',
        ];
    }

    public function attributes()
    {
        return [
            'category_no'     => '标题分类',
            'content'         => '内容',
            'language'        => '语系',
            'broadcast_area'  => '播放地区',
        ];
    }
}
