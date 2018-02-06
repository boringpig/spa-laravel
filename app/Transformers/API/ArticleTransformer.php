<?php

namespace App\Transformers\API;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Entities\Article;

class ArticleTransformer
{
    private $scity_names = [];

    public function __construct()
    {
        $this->scity_names = getSCityArray(); 
    }

    public function transform($data)
    {
        if ($data instanceOf \App\Entities\Article) {
            return $this->format($data);
        } elseif ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $collection = $data->getCollection()->map(function($article) {
                return $this->format($article);
            });
            return new LengthAwarePaginator($collection->toArray(), $data->total(), $data->perPage());
        } else {
            return $data->map(function($article) {
                return $this->format($article);
            });
        }
    }

    private function format(Article $article)
    {
        $scitys = [];
        if(!empty($article->broadcast_area)) {
            foreach ($article->broadcast_area as $value) {
                if(array_key_exists($value, $this->scity_names)) {
                    $scitys[] = $this->scity_names[$value];
                }
            }
        }
        return [
            'title'         => empty($article->category)? '' : $article->category->name,
            'content'       => transformContentImageSrc($article->content),
            'broadcast_area'=> $scitys,
            'language'      => array_get($article, 'language', ''),
        ];
    }
}