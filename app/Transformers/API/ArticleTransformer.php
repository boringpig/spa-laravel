<?php

namespace App\Transformers\API;

use Illuminate\Database\Eloquent\Collection;
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
        if ($data instanceOf Collection) {
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