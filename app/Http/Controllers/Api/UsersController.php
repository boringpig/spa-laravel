<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Support\Facades\Lang;

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
    public function index(Request $request, UserTransformer $transformer)
    {
        try {
            if(! empty($request->all())) {
                $users = $this->userRepository->getByArgs($request->all());
            } else {
                $users = $this->userRepository->getAll();
            }
            if(count($users) == 0) {
                throw new \Exception(Lang::get('message.no_data'));
            }
            $users = $this->userTransformer->transform($users);
            return response()->json($this->successOutput($users), 200);
        } catch (\Exception $e) {
            return response()->json($this->errorOutput($e->getMessage()), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        try {
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
                throw new \Exception(Lang::get('message.store_fail'));
            }
            return response()->json($this->successOutput($user), 200);
        } catch (\Exception $e) {
            return response()->json($this->errorOutput($e->getMessage()), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = $this->userRepository->findOneById($id);
            if(is_null($user)) {
                throw new \Exception(Lang::get('message.no_data'));
            }
            $user = $this->userTransformer->transform($user);
            return response()->json($this->successOutput($user), 200);
        } catch (\Exception $e) {
            return response()->json($this->errorOutput($e->getMessage()), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userRepository->findOneById($id);
            if(is_null($user)) {
                throw new \Exception(Lang::get('message.update_fail'));
            }
            $args = [
                'username'  => $request->username,
                'name'      => $request->name,
                'email'     => $request->email,
                'status'    => ($user->status != $request->status)? $request->status : $user->status,
                'phone'     => $request->phone,
            ];
            if($request->has('password')) {
                $args['password'] = bcrypt($request->password);
            }
            $user = $this->userRepository->update($id, $args);
            return response()->json($this->successOutput($user), 200);
        } catch (\Exception $e) {
            return response()->json($this->errorOutput($e->getMessage()), 500);
        }
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
            $this->userRepository->delete($id);
            return response()->json($this->successOutput($user), 200);
        } catch (\Exception $e) {
            return response()->json($this->errorOutput($e->getMessage()), 500);
        }
    }
}
