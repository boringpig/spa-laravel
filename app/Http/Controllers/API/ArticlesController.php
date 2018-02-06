<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use App\Transformers\API\ArticleTransformer;

class ArticlesController extends Controller
{
    private $articleRepository;
    private $articleTransformer;

    public function __construct(
        ArticleRepository $articleRepository,
        ArticleTransformer $articleTransformer
    ) {
        $this->articleRepository = $articleRepository;
        $this->articleTransformer = $articleTransformer;
    }

    public function index(Request $request)
    {
        $args = $request->all();
        $articles = $this->articleRepository->getByArgs($args);
        $articles = (count($articles) > 0)? $this->articleTransformer->transform($articles)->toArray() : [];
        return response()->json(successOutput($articles), 200);
    }
}
