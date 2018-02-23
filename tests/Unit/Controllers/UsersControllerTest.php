<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Http\Request;
use App\User;

class UsersControllerTest extends TestCase
{
    // use WithoutMiddleware;

    protected $userRepositoryMock = null;
    protected $roleRepositoryMock = null;
    protected $userTransformerMock = null;
    protected $target = null;

    public function setUp()
    {
        parent::setUp();
        $this->userRepositoryMock = $this->initMock('App\Repositories\UserRepository');
        $this->roleRepositoryMock = $this->initMock('App\Repositories\RoleRepository');
        $this->userTransformerMock = $this->initMock('App\Transformers\UserTransformer');
        $this->target = $this->app->make('App\Http\Controllers\UsersController');
    }

    public function tearDown()
    {
        $this->userRepositoryMock = null;
        $this->roleRepositoryMock = null;
        $this->userTransformerMock = null;
        $this->target = null;
        parent::tearDown();
    }

    /**
     * @group user-controller
     */
    public function test成功取得使用者列表()
    {
        // arrange
        $perPage = 2;
        $expected = $this->paginationOfUsers($perPage);
        $this->userRepositoryMock->shouldReceive('getAll')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn($expected);
        $this->userTransformerMock->shouldReceive('transform')
                                  ->once()
                                  ->withAnyArgs()
                                  ->andReturn($expected);
        // act
        $view = $this->target->index(new Request());  // Illuminate\View\View，可以用 get_class 查看型別
        $actual = $view->users;
        // assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * @group user-controller
     */
    public function test使用者新增頁面進入成功()
    {
        // act
        $view = $this->target->create();
        // assert
        $this->assertEquals('users.create', $view->getName());
    }

    /**
     * @group user-controller
     */
    public function test使用者建立成功()
    {
        // arrange
        $form_data = [
            'username'  => 'admin',
            'name'      => 'admin',
            'email'     => 'admin@example.com.tw',
            'password'  => bcrypt('secret'),
            'status'    => 0,
            'phone'     => '123456',
            'role_id'   => '5a72ad2a33523e00272963d2',
        ];
        $request = new CreateUserRequest();
        $query = $request->replace($form_data);
        $this->userRepositoryMock->shouldReceive('create')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn(new User($form_data));
        // act
        $response = $this->target->store($query); // Illuminate\Http\RedirectResponse
        // assert
        $this->assertEquals(302, $response->status());
        $this->assertEquals(route('users.index'), $response->headers->get('location'));
        $this->assertEquals(__('form.created_success'), $response->getSession()->get('success'));
    }

    /**
     * @group user-controller
     */
    public function test使用者建立失敗()
    {
        // arrange
        $form_data = [
            'username'  => 'admin',
            'name'      => 'admin',
            'email'     => 'admin@example.com.tw',
            'password'  => bcrypt('secret'),
            'status'    => 0,
            'phone'     => '123456',
            'role_id'   => '5a72ad2a33523e00272963d2',
        ];
        $request = new CreateUserRequest();
        $query = $request->replace($form_data);
        $this->userRepositoryMock->shouldReceive('create')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn(null);
        // act 
        $response = $this->target->store($query);
        // assert
        $this->assertEquals(302, $response->status());
        $this->assertEquals(route('users.create'), $response->headers->get('location'));
        $this->assertEquals(__('form.created_fail'), $response->getSession()->get('error'));
    }

    /**
     * @group user-controller
     */
    public function test使用者編輯頁進入成功()
    {
        // arrange
        $id = str_random(32);
        $expected = new User([
            'username'  => 'admin',
            'name'      => 'admin',
            'email'     => 'admin@example.com.tw',
            'password'  => bcrypt('secret'),
            'status'    => 0,
            'phone'     => '123456',
            'role_id'   => '5a72ad2a33523e00272963d2',
        ]);
        $this->userRepositoryMock->shouldReceive('findOneById')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn($expected);
        $this->userTransformerMock->shouldReceive('transform')
                                  ->once()
                                  ->withAnyArgs()
                                  ->andReturn($expected);
        // act
        $view = $this->target->edit($id);
        $actual = $view->user;
        // assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * @group user-controller
     */
    public function test使用者編輯頁面進入失敗()
    {
        // arrange
        $id = str_random(32);
        $this->userRepositoryMock->shouldReceive('findOneById')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn(null);
        // act 
        $response = $this->target->edit($id);
        // arrange
        $this->assertEquals(302, $response->status());
        $this->assertEquals(route('users.index'), $response->headers->get('location'));
        $this->assertEquals(__('form.no_data'), $response->getSession()->get('error'));
    }

    /**
     * @group user-controller
     */
    public function test使用者修改成功()
    {
        // arrange
        $form_data = [
            'username'  => 'admin',
            'name'      => 'admin',
            'email'     => 'admin@example.com.tw',
            'password'  => bcrypt('secret'),
            'status'    => 0,
            'phone'     => '23692699',
            'role_id'   => '5a72ad2a33523e00272963d2',
        ];
        $request = new EditUserRequest();
        $query = $request->replace($form_data);
        $this->userRepositoryMock->shouldReceive('findOneById')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn($this->fakeUser());
        $this->userRepositoryMock->shouldReceive('update')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn(new User($form_data));
        // act
        $response = $this->target->update($query, str_random(7));
        // assert
        $this->assertEquals(302, $response->status());
        $this->assertEquals(route('users.index'), $response->headers->get('location'));
        $this->assertEquals(__('form.updated_success'), $response->getSession()->get('success'));
    }

    /**
     * @group user-controller
     */
    public function test使用者不存在DB修改失敗()
    {
        // arrange
        $form_data = [
            'username'  => 'admin',
            'name'      => 'admin',
            'email'     => 'admin@example.com.tw',
            'password'  => bcrypt('secret'),
            'status'    => 0,
            'phone'     => '23692699',
            'role_id'   => '5a72ad2a33523e00272963d2',
        ];
        $request = new EditUserRequest();
        $query = $request->replace($form_data);
        $this->userRepositoryMock->shouldReceive('findOneById')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn(null);
        $id = str_random(7);
        // act
        $response = $this->target->update($query,$id);
        // assert
        $this->assertEquals(302, $response->status());
        $this->assertEquals(route('users.edit', ['id' => $id]), $response->headers->get('location'));
        $this->assertEquals(__('form.no_data'), $response->getSession()->get('error'));
    }

    /**
     * @group user-controller
     */
    public function test使用者修改失敗()
    {
        // arrange
        $form_data = [
            'username'  => 'admin',
            'name'      => 'admin',
            'email'     => 'admin@example.com.tw',
            'password'  => bcrypt('secret'),
            'status'    => 0,
            'phone'     => '23692699',
            'role_id'   => '5a72ad2a33523e00272963d2',
        ];
        $request = new EditUserRequest();
        $query = $request->replace($form_data);
        $this->userRepositoryMock->shouldReceive('findOneById')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn($this->fakeUser());
        $this->userRepositoryMock->shouldReceive('update')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn(false);
        $id = str_random(7);
        // act
        $response = $this->target->update($query,$id);
        // assert
        $this->assertEquals(302, $response->status());
        $this->assertEquals(route('users.edit', ['id' => $id]), $response->headers->get('location'));
        $this->assertEquals(__('form.updated_fail'), $response->getSession()->get('error'));
    }

    /**
     * @group user-controller
     */
    public function test使用者刪除成功()
    {
        // arrange
        $id = str_random(7);
        $user = $this->fakeUser();
        $expected = ['RetCode' => 1,'RetVal' => $user->toArray()];
        $this->userRepositoryMock->shouldReceive('findOneById')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn($user);
        $this->userRepositoryMock->shouldReceive('delete')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn(true);
        // act
        $response = $this->target->destroy($id);
        // assert
        $this->assertEquals(200, $response->status());
        $this->assertEquals($expected, $response->getData(true));
    }

    /**
     * @group user-controller
     */
    public function test使用者不存在DB刪除失敗()
    {
        // arrange
        $id = str_random(7);
        $expected = ['RetCode' => 0,'RetMsg' => __('message.no_data')];
        $this->userRepositoryMock->shouldReceive('findOneById')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn(null);
        // act
        $response = $this->target->destroy($id);
        // assert
        $this->assertEquals(500, $response->status());
        $this->assertEquals($expected, $response->getData(true));
    }

    /**
     * @group user-controller
     */
    public function test使用者刪除失敗()
    {
        // arrange
        $id = str_random(7);
        $user = $this->fakeUser();
        $expected = ['RetCode' => 0,'RetMsg' => __('message.delete_fail')];
        $this->userRepositoryMock->shouldReceive('findOneById')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn($user);
        $this->userRepositoryMock->shouldReceive('delete')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn(false);
        // act
        $response = $this->target->destroy($id);
        // assert
        $this->assertEquals(500, $response->status());
        $this->assertEquals($expected, $response->getData(true));
    }

    /**
     * @group user-controller
     */
    public function test使用者更改密碼成功()
    {
        // arrange
        $id = str_random(7);
        $user = $this->fakeUser();
        $form_data = [
            'password'  => bcrypt('secret'),
        ];
        $request = new ChangePasswordRequest();
        $query = $request->replace($form_data);
        $expected = ['RetCode' => 1,'RetVal' => $user->toArray()];
        $this->userRepositoryMock->shouldReceive('findOneById')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn($user);
        $this->userRepositoryMock->shouldReceive('update')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn(true);
        // act
        $response = $this->target->changePassword($query,$id);
        // assert
        $this->assertEquals(200, $response->status());
        $this->assertEquals($expected, $response->getData(true));        
    }

    /**
     * @group user-controller
     */
    public function test使用者不存在DB更改密碼失敗()
    {
        // arrange
        $id = str_random(7);
        $form_data = [
            'password'  => bcrypt('secret'),
        ];
        $request = new ChangePasswordRequest();
        $query = $request->replace($form_data);
        $expected = ['RetCode' => 0,'RetMsg' => __('message.no_data')];
        $this->userRepositoryMock->shouldReceive('findOneById')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn(null);
        // act
        $response = $this->target->changePassword($query,$id);
        // assert
        $this->assertEquals(500, $response->status());
        $this->assertEquals($expected, $response->getData(true));
    }

    /**
     * @group user-controller
     */
    public function test使用者更改密碼失敗()
    {
        // arrange
        $id = str_random(7);
        $user = $this->fakeUser();
        $form_data = [
            'password'  => bcrypt('secret'),
        ];
        $request = new ChangePasswordRequest();
        $query = $request->replace($form_data);
        $expected = ['RetCode' => 0,'RetMsg' => __('message.change_password_fail')];
        $this->userRepositoryMock->shouldReceive('findOneById')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn($user);
        $this->userRepositoryMock->shouldReceive('update')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn(false);
        // act
        $response = $this->target->changePassword($query,$id);
        // assert
        $this->assertEquals(500, $response->status());
        $this->assertEquals($expected, $response->getData(true));
    }

    /**
     * @group user-controller 
     */
    public function test使用者列表搜尋成功()
    {
        // arrange
        $perPage = 2;
        $form_data = [
            'username'  => 'admin',
            'status'    => 1,
        ];
        $resquest = new Request();
        $query = $resquest->replace($form_data);
        $expected = $this->paginationOfUsers($perPage);
        $this->userRepositoryMock->shouldReceive('getByArgs')
                                 ->once()
                                 ->withAnyArgs()
                                 ->andReturn($expected);
        $this->userTransformerMock->shouldReceive('transform')
                                  ->once()
                                  ->withAnyArgs()
                                  ->andReturn($expected);
        // act
        $view = $this->target->search($query);
        $actual = $view->users;
        // assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * 自定義使用者列表的資料
     *
     * @param string $perPage 分頁數量
     * @return LengthAwarePaginator
     */
    protected function paginationOfUsers($perPage) 
    {
        $users = [
            [
                "id" => "5a8e394f6ac94f2c026ce503",
                "username" => "test",
                "name" => "test",
                "email" => "test@test.test.test",
                "phone" => "1234567890",
                "password" => bcrypt('secret'),
                "status" => 1,
                "role_id" => "5a8e39146ac94f2c0142cc42",
                "role_name" => "test",
                "updated_at" => "2018-02-22 14:48:59"
            ],
            [
                "id" => "5a8cd0ee6ac94f5bbb3afa43",
                "username" => "mptest",
                "name" => "mptest",
                "email" => "mptest@mptest.mptest",
                "phone" => null,
                "password" => bcrypt('secret'),
                "status" => 1,
                "role_id" => "5a72ad2a33523e00272963d2",
                "role_name" => "系統管理者",
                "updated_at" => "2018-02-21 09:52:46",
            ]
        ];

        return new LengthAwarePaginator($users, count($users), $perPage);
    }

    /**
     * 自定義admin使用者
     *
     * @return User
     */
    protected function fakeUser() 
    {
        return new User([
            'username'  => 'admin',
            'name'      => 'admin',
            'email'     => 'admin@example.com.tw',
            'password'  => bcrypt('secret'),
            'status'    => 0,
            'phone'     => '123456',
            'role_id'   => '5a72ad2a33523e00272963d2',
        ]);
    }
}