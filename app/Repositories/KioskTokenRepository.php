<?php

namespace App\Repositories;

use App\Entities\KioskToken;
use App\CPS\Entities\Station;

class KioskTokenRepository extends Repository
{
    public function model()
    {
        return app(KioskToken::class);
    }

    public function tag()
    {
        return 'kiosk_token';
    }

    /**
     * 檢查 token 是否合法
     *
     * @param string $token kiosk授權
     * @return boolean
     */
    public function findByToken($token)
    {
        return $this->model()->where('token', $token)->exists();
    }

    /**
     * 如果不存在 db，則即時去 cps 場站 hash 產生 token 檢查是否合法
     *
     * @param string $token kiosk授權
     * @return boolean
     */
    public function validateToken($token)
    {
        $snos = Station::get()->pluck('s_no')->toArray();

        return collect($snos)->map(function($item) {
                return hash('sha256', $item);
            })->contains($token);
    }
}