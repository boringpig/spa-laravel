<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Entities\Article;

class ArticleTransformer
{
    private $languages = [];

    public function __construct()
    {
        $this->languages = getLanguageList();
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
        return [
            'id'            => $article->_id,
            'title'         => $article->title,
            'content'       => transformContentImageSrc($article->content),
            'broadcast_area'=> empty($article->broadcast_area)? [] : $article->broadcast_area,
            'language'      => $article->language,
            'language_name' => empty($this->languages[$article->language])? "" : $this->languages[$article->language],
            'updated_at'    => $article->updated_at->toDateTimeString(),
        ];
    }
}