<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Article;

class ArticleTransformer
{
    public function transform($data)
    {
        if ($data instanceOf \App\Article) {
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
        $languages = getLanguageList();
        return [
            'id'            => $article->_id,
            'title'         => $article->title,
            'content'       => transformContentImageSrc($article->content),
            'language'      => $article->language,
            'language_name' => empty($languages[$article->language])? "" : $languages[$article->language],
            'updated_at'    => $article->updated_at->toDateTimeString(),
        ];
    }
}