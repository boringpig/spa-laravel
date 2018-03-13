<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ArticleRepository;
use App\Transformers\ArticleTransformer;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\EditArticleRequest;
use Illuminate\Support\Facades\Route;

class ArticlesController extends Controller
{
    protected $articleRepository;
    protected $articleTransformer;

    public function __construct(
        ArticleRepository $articleRepository,
        ArticleTransformer $articleTransformer
    ) {
        $this->middleware(['auth','role.auth','record.actionlog']);
        $this->articleRepository = $articleRepository;
        $this->articleTransformer = $articleTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->articleRepository->getAllWithPermission(config('website.perPage'), ['category']);
        $articles = (count($articles) > 0)? $this->articleTransformer->transform($articles)->setPath("/".Route::current()->uri()) : [];
        return view('articles.index', [
            'articles'   => $articles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateArticleRequest $request)
    {
        // 檢查是否有相同的文章標題、語系
        if($this->articleRepository->checkSameArticle($request->category_no, $request->language)) {
            session()->flash('error', __('form.exists_same_lang_article_title'));            
            return redirect()->back();
        }

        $args = [
            'category_no'    => $request->category_no,
            'content'        => processContent($request->content),
            'language'       => $request->language,
            'broadcast_area' => $request->broadcast_area,
        ];
        
        $article = $this->articleRepository->create($args);
        
        if(is_null($article)) {
            session()->flash('error', __('form.created_fail'));            
            return redirect()->back();
        }
        
        session()->flash('success', __('form.created_success'));
        return redirect()->route('articles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = $this->articleRepository->findOneById($id);

        if(is_null($article)) {
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }

        $article = $this->articleTransformer->transform($article);
        return view('articles.edit', [
            'article'       => $article,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditArticleRequest $request, $id)
    {
        $article = $this->articleRepository->findOneById($id);

        if(is_null($article)) {
            session()->flash('error', __('form.no_data'));
            return redirect()->back();
        }

        // 檢查是否有相同的文章標題、語系，如果與本身文章相符就略過檢查
        if(($article->category_no != $request->category_no) || 
           ($article->language != $request->language)
        ) {
            if($this->articleRepository->checkSameArticle($request->category_no, $request->language)) {
                session()->flash('error', __('form.exists_same_lang_article_title'));            
                return redirect()->back();
            }
        } 
        
        $args = [
            'category_no'    => $request->category_no,
            'content'        => processContent($request->content),
            'language'       => $request->language,
            'broadcast_area' => $request->broadcast_area,
        ];
        if($this->articleRepository->update($id, $args)) {
            session()->flash('success', __('form.updated_success'));
            return redirect()->route('articles.index');
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
            $article = $this->articleRepository->findOneById($id);
            if(is_null($article)) {
                throw new \Exception(__('message.no_data'));
            }
            if(! $this->articleRepository->delete($id)) {
                throw new \Exception(__('message.delete_fail'));
            }
            return response()->json(successOutput($article), 200);
        } catch (\Exception $e) {
            return response()->json(errorOutput($e->getMessage()), 500);
        }
    }

    public function search(Request $request)
    {
        $articles = $this->articleRepository->getByArgsWithPermission($request->all(),config('website.perPage'));
        $articles = (count($articles) > 0)? $this->articleTransformer->transform($articles)->appends($request->all())->setPath("/{$request->path()}") : [];
        $request->flash();
        return view('articles.index', [
            'articles'      => $articles,
        ]);
    }
}
