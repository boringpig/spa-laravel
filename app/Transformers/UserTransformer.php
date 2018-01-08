<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\User;

class UserTransformer
{
    public function transform($data)
    {
        if ($data instanceOf \App\User) {
            return $this->format($data);
        } elseif ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $collection = $data->getCollection()->map(function($user) {
                return $this->format($user);
            });
            return new LengthAwarePaginator($collection->toArray(), $data->total(), $data->perPage());
        } else {
            return $data->map(function($user) {
                return $this->format($user);
            });
        }
    }

    private function format(User $user)
    {
        return [
            'id'            => $user->_id,
            'username'      => $user->username,
            'name'          => $user->name,
            'email'         => $user->email,
            'phone'         => $user->phone,
            'password'      => $user->password,
            'status'        => $user->status,
            'role_id'       => $user->role_id,
            'role_name'     => empty($user->role->name)? "" : $user->role->name, 
            'updated_at'    => $user->updated_at->toDateTimeString(),
        ];
    }
}