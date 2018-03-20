<?php

namespace App\Observers;

use App\Entities\Role;

class RoleObserver
{
    public function updated(Role $role)
    {
        cache()->flush();
    }
}