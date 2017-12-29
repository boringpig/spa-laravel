<?php

use Illuminate\Database\Seeder;
use App\User;

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

        User::create($user1);
        User::create($user2);
    }
}
