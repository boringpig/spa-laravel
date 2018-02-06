<?php

namespace App\Transformers\API;

use App\Entities\Setting;

class SettingTransformer
{
    public function transform($data, $type = 'customer')
    {
        if ($data instanceOf \App\Entities\Setting) {
            switch($type) {
                case 'customer':
                    return $this->customerFormat($data);
                case 'kiosk':
                    return $this->kioskFormat($data);
            }
        }
    }

    private function customerFormat(Setting $setting)
    {
        return [
            'customer_service_phone'    => array_get($setting, 'customer_service_phone', ''),
            'customer_service_email'    => array_get($setting, 'customer_service_email', ''),
        ];
    }

    private function kioskFormat(Setting $setting)
    {
        return [
            'kiosk_freetime'    => array_get($setting, 'kiosk_freetime', ''),
        ];
    }
}