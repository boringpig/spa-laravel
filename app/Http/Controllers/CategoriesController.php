<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Transformers\CategoryTransformer;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\EditCategoryRequest;
use Illuminate\Support\Facades\Route;

class CategoriesController extends Controller
{
    protected $categoryRepository;
    protected $categoryTransformer;

    public function __construct(
        CategoryRepository $categoryRepository,
        CategoryTransformer $categoryTransformer
    ) {
        $this->middleware(['auth','role.auth']);
        $this->categoryRepository = $categoryRepository;
        $this->categoryTransformer = $categoryTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->getAll(config('website.perPage'));
        $categories = (count($categories) > 0)? $this->categoryTransformer->transform($categories)->setPath("/".Route::current()->uri()) : [];
        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $args = [
            'no'    => $request->no,
            'name'  => $request->name,
        ];

        $category = $this->categoryRepository->create($args);
        
        if(is_null($category)) {
            session()->flash('error', __('form.created_fail'));            
            return redirect()->back();
        }
        
        session()->flash('success', __('form.created_success'));
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findOneById($id);

        if(is_null($category)) {
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }

        $category = $this->categoryTransformer->transform($category);

        return view('categories.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCategoryRequest $request, $id)
    {
        $category = $this->categoryRepository->findOneById($id);

        if(is_null($category)) {
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }

        $args = [
            'no'    => $request->no,
            'name'  => $request->name,
        ];
        if($this->categoryRepository->update($id, $args)) {
            session()->flash('success', __('form.updated_success'));
            return redirect()->route('categories.index');
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
            $category = $this->categoryRepository->findOneById($id);
            if(is_null($category)) {
                throw new \Exception(__('message.no_data'));
            }
            if(! $this->categoryRepository->delete($id)) {
                throw new \Exception(__('message.delete_fail'));
            }
            return response()->json(successOutput($category), 200);
        } catch (\Exception $e) {
            return response()->json(errorOutput($e->getMessage()), 500);
        }
    }
}
