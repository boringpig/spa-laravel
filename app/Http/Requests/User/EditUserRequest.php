<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class EditUserRequest extends FormRequest
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
			'username'  => 'required|string|max:20|unique:users',
            'email'     => 'required|string|email|max:255|unique:users',
            'name'      => 'required|string|max:20',
        ];
        
		$user = User::find($_REQUEST['id']);
		if ($_REQUEST['email'] === $user->email){
			$rules['email'] = 'required|string|email|max:255';
		}
		if ($_REQUEST['username'] === $user->username){
			$rules['username'] = 'required|string|max:20';
        }
        
        return $rules;
    }
}
