<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use App\User;

class UserTransformer
{
    public function transform($data)
    {
        if($data instanceOf \App\User) {
            return $this->format($data);
        } else {
            return $data->map(function($user) {
                return $this->format($user);
            });
        }
    }

    private function format(User $user)
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'status' => ($user->status == 1)? '啟用' : '禁用',
            'updated_at' => $user->updated_at->toDateTimeString(),
            'created_at' => $user->created_at->toDateTimeString(),
        ];
    }
}