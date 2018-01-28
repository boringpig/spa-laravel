<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Entities\Role;

class RoleTransformer
{
    public function transform($data)
    {
        if ($data instanceOf \App\Entities\Role) {
            return $this->format($data);
        } elseif ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $collection = $data->getCollection()->map(function($role) {
                return $this->format($role);
            });
            return new LengthAwarePaginator($collection->toArray(), $data->total(), $data->perPage());
        } else {
            return $data->map(function($role) {
                return $this->format($role);
            });
        }
    }

    private function format(Role $role)
    {
        return [
            'id'            => $role->_id,
            'name'          => $role->name,
            'usernames'     => empty($role->users)? [] : $role->users->pluck('username')->toArray(),
            'permission'    => empty($role->permission)? [] : $role->permission,
            'updated_at'    => $role->updated_at->toDateTimeString(),
        ];
    }
}