<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * 初始化mock物件
     *
     * @param string $class
     * @return Mockery
     */
    public function initMock($class)
    {
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);

        return $mock;
    }

    /**
     * 有些方法必須為登入後才可以執行
     *
     * @return void
     */
    public function userLoggedIn()
    {
        $user = new \App\User([
            "name" => "phpunit", 
            "username" => "phpunit", 
            "email" => "phpunit@program.com.tw", 
            "password" => bcrypt('secret'), 
            "phone" => "23692699", 
            "status" => 1, 
            "role_id" => "5a72ad2a33523e00272963d2", 
            "role_objectid" => new \MongoDB\BSON\ObjectID("5a72ad2a33523e00272963d2"), 
            "updated_at" => new \MongoDB\BSON\UTCDateTime(time() * 1000), 
            "created_at" => new \MongoDB\BSON\UTCDateTime(time() * 1000), 
        ]);
        $this->be($user);
    }
}
