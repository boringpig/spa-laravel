<?php

namespace App\Http\Requests\Advertisement;

use Illuminate\Foundation\Http\FormRequest;
use App\Entities\Advertisement;

class EditAdvertisementRequest extends FormRequest
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
            'name'                  => 'required|string|unique:advertisementxs',
            'broadcast_area'        => 'required|array',
            'round_time'            => 'required|numeric|min:0',
            'weeks'                 => 'required|array',
            'broadcast_start_time'  => 'required|regex:/^\d{1,2}:\d{1,2}$/',
            'broadcast_end_time'    => 'required|regex:/^\d{1,2}:\d{1,2}$/',
            'publish_at'            => 'required|date_format:Y-m-d',
        ];
        
        $advertisement = Advertisement::find($_REQUEST['id']);
		if ($_REQUEST['name'] === $advertisement->name){
			$rules['name'] = 'required|string';
		}
        
        return $rules;
    }

    public function attributes()
    {
        return [
            'name'                      => '广告名称',
            'round_time'                => '循环秒数',
            'weeks'                     => '循环星期',
            'publish_at'                => '发布日期',
            'broadcast_area'            => '播放地区',
            'broadcast_start_time'      => '',
            'broadcast_end_time'        => '',
        ];
    }
}
