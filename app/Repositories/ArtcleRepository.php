<?php

namespace App\Repositories;

use App\Article;

class ArticleRepository extends Repository
{

    public function model()
    {
        return app(Article::class);
    }

    /**
     * 根據搜尋參數回傳符合條件的使用者
     */
    public function getByArgs($args, $perPage = null)
    {
        $condition = [];

        foreach(['language', 'title'] as $field) {
            if(array_key_exists($field, $args) && $args[$field] != '') {
                $condition[$field] = ['$eq' => $args[$field]];
            }    
        }
        
        if(array_key_exists('updated_at', $args) && !empty($args['updated_at'])) {
            $condition['updated_at'] = ['$gte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['updated_at']} 00:00:00") * 1000),
                                        '$lte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['updated_at']} 23:59:59") * 1000)];
        }

        $query = $this->model()->whereRaw($condition)->orderBy('created_at','desc');

        return is_null($perPage)? $query->get() : $query->paginate($perPage);
    }
    
    /**
     * 檢查唯一的文章標題、語系
     *
     */
    public function checkSameArticle($title, $language)
    {
        $condition = [
            'title' => ['$eq' => $title],
            'language' => ['$eq' => $language],
        ];
        
        return $this->model()->whereRaw($condition)->exists();
    }
}