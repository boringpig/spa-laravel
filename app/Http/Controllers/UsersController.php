<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

class UsersController extends Controller
{
    protected $userRepository;
    protected $userTransformer;

    public function __construct(UserRepository $userRepository, UserTransformer $userTransformer)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->getAll(config('website.perPage'));
        $users = (count($users) > 0)? $this->userTransformer->transform($users)->setPath("/".Route::current()->uri()) : [];
        return view('users.index', [
            'page_title' => Lang::get('pageTitle.users_manage'),
            'users'      => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', [
            'page_title' => Lang::get('pageTitle.users_manage')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $args = [
            'username'  => $request->username,
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'status'    => $request->has('status')? (int) $request->status : 0,
            'phone'     => $request->phone,
        ];

        $user = $this->userRepository->create($args);
        
        if(is_null($user)) {
            Sesssion::flash('error', Lang::get('form.created_fail'));            
            return redirect()->back();
        }
        
        Session::flash('success', Lang::get('form.created_success'));
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findOneById($id);

        if(is_null($user)) {
            Session::flash('error', Lang::get('form.no_data'));
            return redirect()->back();
        }

        $user = $this->userTransformer->transform($user);

        return view('users.edit', [
            'page_title' => Lang::get('pageTitle.users_manage'),
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
    {
        $user = $this->userRepository->findOneById($id);

        if(is_null($user)) {
            Session::flash('error', Lang::get('form.no_data'));
            return redirect()->back();
        }
        // 啟用/禁用 是用checkbox有選擇才有回傳值，反之沒有
        $status = $request->has('status')? 1 : 0;
        $args = [
            'username'  => $request->username,
            'name'      => $request->name,
            'email'     => $request->email,
            'status'    => ($user->status != $status)? $status : $user->status,
            'phone'     => $request->phone,
        ];
        if($this->userRepository->update($id, $args)) {
            Session::flash('success', Lang::get('form.updated_success'));
            return redirect()->route('users.index');
        }

        Session::flash('error', Lang::get('form.updated_fail'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = $this->userRepository->findOneById($id);
            if(is_null($user)) {
                throw new \Exception(Lang::get('message.no_data'));
            }
            if(! $this->userRepository->delete($id)) {
                throw new \Exception(Lang::get('message.delete_fail'));
            }
            return response()->json($this->successOutput($user), 200);
        } catch (\Exception $e) {
            return response()->json($this->errorOutput($e->getMessage()), 500);
        }
    }

    public function changePassword(ChangePasswordRequest $request, $id)
    {
        try {
            $user = $this->userRepository->findOneById($id);
            if(is_null($user)) {
                throw new \Exception(Lang::get('message.no_data'));
            }
            $args = [
                'password' => bcrypt($request->password),
            ];
            if(! $this->userRepository->update($id, $args)) {
                throw new \Exception(Lang::get('message.change_password_fail'));
            }        
            return response()->json($this->successOutput($user), 200);
        } catch (\Exception $e) {
            return response()->json($this->errorOutput($e->getMessage()), 500);
        }
    }

    public function search(Request $request)
    {
        $users = $this->userRepository->getByArgs($request->all(),config('website.perPage'));
        $users = (count($users) > 0)? $this->userTransformer->transform($users)->appends($request->all())->setPath("/{$request->path()}") : [];
        $request->flash();
        return view('users.index', [
            'page_title' => Lang::get('pageTitle.users_manage'),
            'users'      => $users,
        ]);
    }
}
