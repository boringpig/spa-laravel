<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RoleRepository;
use App\Transformers\RoleTransformer;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\EditRoleRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class RolesController extends Controller
{
    protected $roleRepository;
    protected $roleTransformer;

    public function __construct(RoleRepository $roleRepository, RoleTransformer $roleTransformer)
    {
        $this->middleware('auth');
        $this->roleRepository = $roleRepository;
        $this->roleTransformer = $roleTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleRepository->getAll(config('website.perPage'));
        $roles = (count($roles) > 0)? $this->roleTransformer->transform($roles)->setPath("/".Route::current()->uri()) : [];
        return view('roles.index', [
            'page_title' => Lang::get('pageTitle.users_manage'),
            'roles'      => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create', [
            'page_title'    => Lang::get('pageTitle.users_manage'),
            'menu_list'     => config('menu'),
            'button_list'   => config('button'),
            'data'          => $this->processPermissionList(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
    {
        $args = [
            'name'          => $request->name,
            'permission'    => $request->permission,
        ];
        $role = $this->roleRepository->create($args);

        if(is_null($role)) {
            Session::flash('error', Lang::get('form.created_fail'));
            return redirect()->back();
        }

        Session::flash('success', Lang::get('form.created_success'));
        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->findOneById($id);

        if(is_null($role)) {
            Session::flash('error', Lang::get('form.no_data'));
            return redirect()->back();
        }
        $role = $this->roleTransformer->transform($role);
        return view('roles.edit', [
            'page_title'    => Lang::get('pageTitle.users_manage'),
            'menu_list'     => config('menu'),
            'button_list'   => config('button'),
            'data'          => $this->processPermissionList(),
            'role'          => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRoleRequest $request, $id)
    {
        $role = $this->roleRepository->findOneById($id);

        if(is_null($role)) {
            Session::flash('error', Lang::get('form.no_data'));
            return redirect()->back();
        }
        $args = [
            'name'          => $request->name,
            'permission'    => $request->permission,
        ];
        if($this->roleRepository->update($id, $args)) {
            Session::flash('success', Lang::get('form.updated_success'));
            return redirect()->route('roles.index');
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
            $role = $this->roleRepository->findOneById($id);
            if(is_null($role)) {
                throw new \Exception(Lang::get('message.no_data'));
            }
            if(! $this->roleRepository->delete($id)) {
                throw new \Exception(Lang::get('message.delete_fail'));
            }
            return response()->json($this->successOutput($role), 200);
        } catch (\Exception $e) {
            return response()->json($this->errorOutput($e->getMessage()), 500);
        }
    }

    public function search(Request $request)
    {
        $roles = $this->roleRepository->getByArgs($request->all(), config('website.perPage'));
        $roles = (count($roles) > 0 )? $this->roleTransformer->transform($roles)->appends($request->all())->setPath("/{$request->path()}") : [];
        $request->flash();
        return view('roles.index', [
            'page_title' => Lang::get('pageTitle.users_manage'),
            'roles' => $roles,
        ]);
    }

    private function processPermissionList()
    {
        $routeCollection = Route::getRoutes();
        $data = [];
        foreach ($routeCollection as $route) {
            if(str_contains($route->getName(), '.')) {
                $menu = explode('.',$route->getName())[0];
                $button = explode('.',$route->getName())[1];
                if(array_key_exists($menu, config('menu'))) {
                    $data[$menu][] = $button;
                }
            }
        }

        return $data;
    }
}
