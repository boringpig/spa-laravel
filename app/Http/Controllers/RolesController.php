<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RoleRepository;
use App\Transformers\RoleTransformer;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\EditRoleRequest;
use Illuminate\Support\Facades\Route;

class RolesController extends Controller
{
    protected $roleRepository;
    protected $roleTransformer;

    public function __construct(RoleRepository $roleRepository, 
                                RoleTransformer $roleTransformer
    ) {
        $this->middleware(['auth','role.auth']);
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
            session()->flash('error', __('form.created_fail'));
            return redirect()->back();
        }

        session()->flash('success', __('form.created_success'));
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
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }
        $role = $this->roleTransformer->transform($role);

        return view('roles.edit', [
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
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }
        $args = [
            'name'          => $request->name,
            'permission'    => $request->permission,
        ];
        if($this->roleRepository->update($id, $args)) {
            session()->flash('success', __('form.updated_success'));
            return redirect()->route('roles.index');
        }

        session()->flash('error', __('form.updated_fail'));
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
                throw new \Exception(__('message.no_data'));
            }
            if(! $this->roleRepository->delete($id)) {
                throw new \Exception(__('message.delete_fail'));
            }
            return response()->json(successOutput($role), 200);
        } catch (\Exception $e) {
            return response()->json(errorOutput($e->getMessage()), 500);
        }
    }

    public function search(Request $request)
    {
        $roles = $this->roleRepository->getByArgs($request->all(), config('website.perPage'));
        $roles = (count($roles) > 0 )? $this->roleTransformer->transform($roles)->appends($request->all())->setPath("/{$request->path()}") : [];
        $request->flash();
        return view('roles.index', [
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
