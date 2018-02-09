<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AreaGroupRepository;
use App\Transformers\AreaGroupTransformer;
use App\Http\Requests\AreaGroup\EditAreaGroupRequest;
use Illuminate\Support\Facades\Route;

class AreaGroupsController extends Controller
{
    protected $areaGroupRepository;
    protected $areaGroupTransformer;

    public function __construct(
        AreaGroupRepository $areaGroupRepository,
        AreaGroupTransformer $areaGroupTransformer
    ) {
        $this->middleware(['auth','role.auth','record.actionlog']);
        $this->areaGroupRepository = $areaGroupRepository;
        $this->areaGroupTransformer = $areaGroupTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = $this->areaGroupRepository->getAllOrCreateNewArea(config('website.perPage'));
        $groups = (count($groups) > 0)? $this->areaGroupTransformer->transform($groups)->setPath("/".Route::current()->uri()) : [];
        return view('areagroups.index', [
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = $this->areaGroupRepository->findOneById($id);

        if(is_null($group)) {
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }

        $group = $this->areaGroupTransformer->transform($group);

        return view('areagroups.edit', [
            'group' => $group,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditAreaGroupRequest $request, $id)
    {
        $group = $this->areaGroupRepository->findOneById($id);

        if(is_null($group)) {
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }

        $args = [
            'child_area'  => $request->child_area,
        ];
        if($this->areaGroupRepository->update($id, $args)) {
            session()->flash('success', __('form.updated_success'));
            return redirect()->route('areagroups.index');
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
            $group = $this->areaGroupRepository->findOneById($id);
            if(is_null($group)) {
                throw new \Exception(__('message.no_data'));
            }
            if(! $this->areaGroupRepository->delete($id)) {
                throw new \Exception(__('message.delete_fail'));
            }
            return response()->json(successOutput($group), 200);
        } catch (\Exception $e) {
            return response()->json(errorOutput($e->getMessage()), 500);
        }
    }
}
