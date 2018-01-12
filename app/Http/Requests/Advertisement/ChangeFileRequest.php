<?php

namespace App\Http\Requests\Advertisement;

use Illuminate\Foundation\Http\FormRequest;

class ChangeFileRequest extends FormRequest
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
            'path'          => 'required|file|mimes:jpg,jpeg,png,gif,mp4',
        ];
    }

    public function attributes()
    {
        return [
            'path'          => '图片/影音',
        ];
    }
}
