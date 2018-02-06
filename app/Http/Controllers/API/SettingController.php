<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Transformers\API\SettingTransformer;

class SettingController extends Controller
{
    private $settingRepository;
    private $settingTransformer;

    public function __construct(
        SettingRepository $settingRepository,
        SettingTransformer $settingTransformer
    ) {
        $this->settingRepository = $settingRepository;
        $this->settingTransformer = $settingTransformer;
    }

    public function getCustomerData()
    {
        $setting = $this->settingRepository->findOne();
        $setting = $this->settingTransformer->transform($setting);
        return response()->json(successOutput($setting), 200);
    }

    public function getKioskFreetime()
    {
        $setting = $this->settingRepository->findOne();
        $setting = $this->settingTransformer->transform($setting,'kiosk');
        return response()->json(successOutput($setting), 200);
    }
}
