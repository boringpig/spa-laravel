<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SettingRepository;
use App\Http\Requests\Setting\CreateSettingRequest;

class SettingController extends Controller
{
    private $settingRepository;

    public function __construct(
        SettingRepository $settingRepository
    ) {
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        $setting = $this->settingRepository->findOne();

        return view('settings.index', [
            'setting' => $setting
        ]);
    }

    public function store(CreateSettingRequest $request)
    {
        $args = [];
        foreach($request->except('_token') as $key => $field) {
            if(!is_null($field)) {
                $args[$key] = $field;
            }
        }

        if(empty($args)) {
            session()->flash('error', __('form.enter_at_least_one_field'));            
            return redirect()->back();
        }

        // 建立或修改系統設定
        $setting = $this->settingRepository->createOrUpdate($args);
        
        if(!$setting) {
            session()->flash('error', __('form.setting_data_save_fail'));            
            return redirect()->back();
        }

        session()->flash('success', __('form.setting_data_save_success'));
        return redirect()->back();
    }
}
