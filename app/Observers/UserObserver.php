<?php

namespace App\Observers;

use App\User;
use App\Notifications\ModifyUserNotification;

class UserObserver
{
    protected $admins;

    public function __construct()
    {
        $pipeline = [
            [
                '$lookup' => [
                    'from' => 'roles',
                    'foreignField' => '_id',
                    'localField' => 'role_objectid',
                    'as' => 'role'
                ]
            ],
            [
                '$match' => [
                    'role.name' => '系統管理者',
                ]
            ]
        ];
        $this->admins = User::raw(function($collection) use ($pipeline) {
            return $collection->aggregate($pipeline);
        });
        /**
         * 當有用project指定lookup特定欄位顯示為bsonArray可用bsonSerialize解開
         * $bsonSerialize = $users->role_name->bsonSerialize();
         */
    }

    public function updating(User $user)
    {
        foreach($this->admins as $admin) {
            $admin->notify(new ModifyUserNotification($user));
        }
    }
}