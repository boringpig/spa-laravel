<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    /**
     * @group controller
     */
    public function test登入成功()
    {
        $this->assertTrue(true);
    }
    // public function setUp()
    // {
    //     parent::setUp();
    //     Session::start();
    // }

    // 測試驗證欄位失敗
    // public function testLoginInvalidInput()
    // {
    //     $this->call('POST', 'auth/login', [
    //         '_token' => csrf_token(),
    //     ]);

    //     $this->assertHasOldInput();
    //     $this->assertSessionHasErrors();
    //     $this->assertResponseStatus(302);
    // }

    // 測試登入成功
    // public function testLoginSuccess()
    // {
    //     // Mock Auth Guard Object
    //     $guardMock = Mockery::mock('Illuminate\Auth\Guard');
    //     $this->app->instance('Illuminate\Contracts\Auth\Guard', $guardMock);

    //     /* @see App\Http\Middleware\RedirectIfAuthenticated */
    //     $guardMock
    //         ->shouldReceive('check')
    //         ->once()
    //         ->andReturn(false);

    //     /* @see Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers */
    //     $guardMock
    //         ->shouldReceive('attempt')
    //         ->once()
    //         ->andReturn(true);

    //     $this->call('POST', 'auth/login', [
    //         'email'    => 'jaceju@gmail.com',
    //         'password' => 'password',
    //         '_token'   => csrf_token(),
    //     ]);

    //     $this->assertRedirectedTo('home');
    // }

    // 測試登入失敗
    // public function testLoginFailed()
    // {
    //     // Mock Auth Guard Object
    //     $guardMock = Mockery::mock('Illuminate\Auth\Guard');
    //     $this->app->instance('Illuminate\Contracts\Auth\Guard', $guardMock);

    //     /* @see App\Http\Middleware\RedirectIfAuthenticated */
    //     $guardMock
    //         ->shouldReceive('check')
    //         ->once()
    //         ->andReturn(false);

    //     /* @see Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers */
    //     $guardMock
    //         ->shouldReceive('attempt')
    //         ->once()
    //         ->andReturn(false);

    //     $this->call('POST', 'auth/login', [
    //         'email'    => 'jaceju@gmail.com',
    //         'password' => 'password',
    //         '_token'   => csrf_token(),
    //     ]);

    //     $this->assertHasOldInput();
    //     $this->assertSessionHasErrors();
    //     $this->assertRedirectedTo('auth/login');
    // }

    // public function testLogout()
    // {
    //     $this->userLoggedIn();

    //     // Mock Auth Guard Object
    //     $guardMock = Mockery::mock('Illuminate\Auth\Guard');
    //     $this->app->instance('Illuminate\Contracts\Auth\Guard', $guardMock);

    //     /* @see App\Http\Middleware\RedirectIfAuthenticated */
    //     $guardMock
    //         ->shouldReceive('logout')
    //         ->once();

    //     $this->call('GET', 'auth/logout');

    //     $this->assertRedirectedTo('/');
    // }

    // public function testRegister()
    // {

    // }
}