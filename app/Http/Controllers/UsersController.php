<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Transformers\UserTransformer;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

class UsersController extends Controller
{
    protected $userRepository;
    protected $roleRepository;
    protected $userTransformer;
    static $sortField = ['updated_at' => 'desc'];

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository, 
        UserTransformer $userTransformer
    ) {
        $this->middleware(['auth','record.actionlog']);
        $this->middleware('role.auth', ['except' => 'changePassword']);
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->getAll(config('website.perPage'),[],self::$sortField);
        $users = (count($users) > 0)? $this->userTransformer->transform($users)->setPath("/{$request->path()}") : [];
        return view('users.index', [
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
        return view('users.create');
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
            'role_id'   => $request->role_id,
            'role_objectid'   => new \MongoDB\BSON\ObjectID($request->role_id),
        ];

        $user = $this->userRepository->create($args);
        
        if(is_null($user)) {
            session()->flash('error', __('form.created_fail'));            
            return redirect()->route('users.create');
        }
        
        session()->flash('success', __('form.created_success'));
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
            session()->flash('error', __('form.no_data'));
            return redirect()->route('users.index');
        }

        $user = $this->userTransformer->transform($user);

        return view('users.edit', [
            'user'          => $user,
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
            session()->flash('error', __('form.no_data'));
            return redirect()->route('users.edit', ['id' => $id]);
        }
        // 啟用/禁用 是用checkbox有選擇才有回傳值，反之沒有
        $status = $request->has('status')? 1 : 0;
        $args = [
            'username'  => $request->username,
            'name'      => $request->name,
            'email'     => $request->email,
            'status'    => ($user->status != $status)? $status : $user->status,
            'phone'     => $request->phone,
            'role_id'   => $request->role_id,
            'role_objectid'   => new \MongoDB\BSON\ObjectID($request->role_id),
        ];
        if($this->userRepository->update($id, $args)) {
            session()->flash('success', __('form.updated_success'));
            return redirect()->route('users.index');
        }

        session()->flash('error', __('form.updated_fail'));
        return redirect()->route('users.edit', ['id' => $id]);
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
                throw new \Exception(__('message.no_data'));
            }
            if(! $this->userRepository->delete($id)) {
                throw new \Exception(__('message.delete_fail'));
            }
            return response()->json(successOutput($user), 200);
        } catch (\Exception $e) {
            return response()->json(errorOutput($e->getMessage()), 500);
        }
    }

    public function changePassword(ChangePasswordRequest $request, $id)
    {
        try {
            $user = $this->userRepository->findOneById($id);
            if(is_null($user)) {
                throw new \Exception(__('message.no_data'));
            }
            $args = [
                'password' => bcrypt($request->password),
            ];
            if(! $this->userRepository->update($id, $args)) {
                throw new \Exception(__('message.change_password_fail'));
            }        
            return response()->json(successOutput($user), 200);
        } catch (\Exception $e) {
            return response()->json(errorOutput($e->getMessage()), 500);
        }
    }

    public function search(Request $request)
    {
        $users = $this->userRepository->getByArgs($request->getQueryString(),$request->all(),config('website.perPage'),self::$sortField);
        $users = (count($users) > 0)? $this->userTransformer->transform($users)->appends($request->all())->setPath("/{$request->path()}") : [];
        if(session()->isStarted()) {
            $request->flash();
        }
        return view('users.index', [
            'users'      => $users,
        ]);
    }
}
