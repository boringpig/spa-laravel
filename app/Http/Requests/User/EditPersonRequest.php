<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class EditPersonRequest extends FormRequest
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
            'email'     => 'required|string|email|max:255|unique:users',
            'name'      => 'required|string|max:20',
        ];
        
		$user = User::find($_REQUEST['id']);
		if ($_REQUEST['email'] === $user->email){
			$rules['email'] = 'required|string|email|max:255';
		}
        
        return $rules;
    }

    public function attributes()
    {
        return [
            'name'          => '姓名',
            'email'         => '信箱',
        ];
    }
}
