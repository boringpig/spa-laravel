<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersControllerTest extends TestCase
{
    // 用 Mockery 隔離 repository
    protected $repositoryMock = null;

    // public function setUp()
    // {
    //     parent::setUp();

        // Mockery::mock 可以利用 Reflection 機制幫我們建立假物件
        // $this->repositoryMock = Mockery::mock('App\Repositories\ArticleRepository');

        // Service Container 的 instance 方法可以讓我們
        // 用假物件取代原來的 ArticleRepository 物件
        // $this->app->instance('App\Repositories\ArticleRepository', $this->repositoryMock);
    // }

    // 有些方法必須為登入後才可以執行
    // protected function userLoggedIn()
    // {
    //     $this->be(new User(['email' => 'username@example.com']));
    // }

    // public function testCreateArticleSuccess()
    // {
    //     // 把 Session::start 移到 setUp

    //     // 模擬使用者已登入
    //     $this->userLoggedIn();

    //     // 以下不變
    //     // ...
    // }
    // 測試沒有登入存取失敗
    // public function testAuthFailed()
    // {
    //     $this->call('POST', 'articles', [
    //         '_token' => csrf_token(),
    //     ]);
    //     $this->assertRedirectedTo('auth/login');
    // }
    // public function testArticleList()
    // {
    //     // 確認程式會呼叫一次 ArticleRepository::latest10 方法
    //     // 實際上是為這個 mock object 加入 latest10 方法
    //     // 沒有呼叫到的話就會發出異常
    //     // 再假設它會回傳 foo 這個字串
    //     // 這樣就不需要真的去連結資料庫
    //     $this->repositoryMock
    //         ->shouldReceive('latest10')
    //         ->once()
    //         ->andReturn([]);

    //     $this->call('GET', '/');
    //     $this->assertResponseOk();

    //     // 應取得 articles 變數
    //     // 而其值為空陣列
    //     $this->assertViewHas('articles', []);
    // }

    // public function testCsrfFailed()
    // {
    //     // 模擬沒有 token 時
    //     // 程式應該是輸出 500 Error
    //     $this->call('POST', 'articles');
    //     $this->assertResponseStatus(500);
    // }

    // 測試沒有填值送出表單的驗證錯誤
    // public function testCreateArticleFails()
    // {
    //     Session::start();

    //     $this->call('POST', 'articles', [
    //         '_token' => csrf_token(),
    //     ]);

    //     $this->assertHasOldInput();
    //     $this->assertSessionHasErrors();

    //     // 應該會導回前一個 URL
    //     $this->assertResponseStatus(302);
    // }

    // 測試新增資料成功時的行為
    // public function testCreateArticleSuccess()
    // {
    //     // 會呼叫到 ArticleRepository::create
    //     $this->repositoryMock
    //         ->shouldReceive('create')
    //         ->once();

    //     // 初始化 Session ，因為需要避免 CSRF 的 token
    //     Session::start();

    //     // 模擬送出表單
    //     $this->call('POST', 'articles', [
    //         'title' => 'title 999',
    //         'body' => 'body 999',
    //         '_token' => csrf_token(), // 手動加入 _token
    //     ]);

    //     // 完成後會導向列表頁
    //     $this->assertRedirectedToRoute('articles.index');
    // }

    /**
     * @group controller
     */
    public function test使用者()
    {
        $this->assertTrue(true);
    }

    public function tearDown()
    {
        // 每次完成 test case 後，要清除掉被 mock 的假物件
        // Mockery::close();
    }
}