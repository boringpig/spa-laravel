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
            'title'     => 'required|string',
            'content'   => 'required|string',
            'language'  => 'required|string|in:zh-CN,zh-TW,en',
            'broadcast_area' => 'required|array',
        ];
    }

    public function attributes()
    {
        return [
            'title'           => '标题',
            'content'         => '内容',
            'language'        => '语系',
            'broadcast_area'  => '播放地区',
        ];
    }
}
