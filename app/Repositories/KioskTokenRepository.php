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

    public function findByToken($token)
    {
        return $this->model()->where('token', $token)->exists();
    }

    public function validateToken($token)
    {
        $snos = Station::get()->pluck('s_no')->toArray();

        return collect($snos)->map(function($item) {
                return hash('sha256', $item);
            })->contains($token);
    }
}