<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Entities\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = [
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@program.com.tw',
            'password' => bcrypt('secret'),
            'phone' => '23692699',
            'status' => 1, 
        ];

        $user2 = [
            'name' => 'customer',
            'username'  => 'customer',
            'email' => 'customer@program.com.tw',
            'password' => bcrypt('secret'),
            'phone' => '23692699',
            'status' => 0,
        ];


        $role = [
            "name" => "role_manager", 
            "permission" => [
                "roles.search", 
                "roles.index", 
                "roles.store", 
                "roles.update", 
                "roles.destroy"
            ]
        ];
        
        $role = Role::create($role);
        $user1['role_id'] = $role->_id;
        User::create($user1);
        User::create($user2);
    }
}
