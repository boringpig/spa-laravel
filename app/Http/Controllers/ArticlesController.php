<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ArticleRepository;
use App\Transformers\ArticleTransformer;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\EditArticleRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

class ArticlesController extends Controller
{
    protected $articleRepository;
    protected $articleTransformer;

    public function __construct(ArticleRepository $articleRepository,
                                ArticleTransformer $articleTransformer
    ) {
        $this->middleware(['auth','role.auth']);
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
        $articles = $this->articleRepository->getAll(config('website.perPage'));
        $articles = (count($articles) > 0)? $this->articleTransformer->transform($articles)->setPath("/".Route::current()->uri()) : [];
        return view('articles.index', [
            'page_title' => Lang::get('pageTitle.articles_manage'),
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
        return view('articles.create', [
            'page_title' => Lang::get('pageTitle.articles_manage'),
        ]);
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
        if($this->articleRepository->checkSameArticle($request->title, $request->language)) {
            Session::flash('error', Lang::get('form.exists_same_lang_article_title'));            
            return redirect()->back();
        }

        $args = [
            'title'     => $request->title,
            'content'   => processContent($request->content),
            'language'  => $request->language,
        ];
        
        $article = $this->articleRepository->create($args);
        
        if(is_null($article)) {
            Session::flash('error', Lang::get('form.created_fail'));            
            return redirect()->back();
        }
        
        Session::flash('success', Lang::get('form.created_success'));
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
            Session::flash('error', Lang::get('form.no_data'));
            return redirect()->back();
        }

        $article = $this->articleTransformer->transform($article);
        return view('articles.edit', [
            'page_title'    => Lang::get('pageTitle.articles_manage'),
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
            Session::flash('error', Lang::get('form.no_data'));
            return redirect()->back();
        }

        // 檢查是否有相同的文章標題、語系，如果與本身文章相符就略過檢查
        if( ($article->title != $request->title) 
            && ($article->language != $request->language)
            && $this->articleRepository->checkSameArticle($request->title, $request->language, $article)
        ) {
            Session::flash('error', Lang::get('form.exists_same_lang_article_title'));            
            return redirect()->back();
        }
        $args = [
            'title'     => $request->title,
            'content'   => processContent($request->content),
            'language'  => $request->language,
        ];
        if($this->articleRepository->update($id, $args)) {
            Session::flash('success', Lang::get('form.updated_success'));
            return redirect()->route('articles.index');
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
            $article = $this->articleRepository->findOneById($id);
            if(is_null($article)) {
                throw new \Exception(Lang::get('message.no_data'));
            }
            if(! $this->articleRepository->delete($id)) {
                throw new \Exception(Lang::get('message.delete_fail'));
            }
            return response()->json($this->successOutput($article), 200);
        } catch (\Exception $e) {
            return response()->json($this->errorOutput($e->getMessage()), 500);
        }
    }

    public function search(Request $request)
    {
        $articles = $this->articleRepository->getByArgs($request->all(),config('website.perPage'));
        $articles = (count($articles) > 0)? $this->articleTransformer->transform($articles)->appends($request->all())->setPath("/{$request->path()}") : [];
        $request->flash();
        return view('articles.index', [
            'page_title' => Lang::get('pageTitle.article_manage'),
            'articles'      => $articles,
        ]);
    }
}