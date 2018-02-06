<?php

namespace App\Transformers\API;

use Illuminate\Database\Eloquent\Collection;
use App\Entities\Advertisement;

class AdvertisementTransformer
{
    private $week_names = [];
    private $scity_names = [];

    public function __construct()
    {
        $this->week_names = config('weeks.cn');
        $this->scity_names = getSCityArray(); 
    }

    public function transform($data)
    {
        if ($data instanceOf Collection) {
            return $data->map(function($advertisement) {
                return $this->format($advertisement);
            });
        }
    }

    private function format(Advertisement $advertisement)
    {
        $weeks = [];
        $scitys = [];
        if(!empty($advertisement->weeks)) {
            foreach($advertisement->weeks as $value) {
                if(array_key_exists($value, $this->week_names)) {
                    $weeks[] = $this->week_names[$value];
                }
            }
        }
        if(!empty($advertisement->broadcast_area)) {
            foreach ($advertisement->broadcast_area as $value) {
                if(array_key_exists($value, $this->scity_names)) {
                    $scitys[] = $this->scity_names[$value];
                }
            }
        }
        return [
            'name'                  => array_get($advertisement, 'name', ''),
            'path'                  => empty($advertisement->path)? '' : asset($advertisement->path),
            'round_time'            => array_get($advertisement, 'round_time', ''),
            'weeks'                 => $weeks,
            'status'                => ($advertisement->status)? __('form.enable') : __('form.disable'),
            'broadcast_area'        => $scitys,
            'broadcast_time'        => array_get($advertisement, 'broadcast_time', ''),
        ];
    }
}