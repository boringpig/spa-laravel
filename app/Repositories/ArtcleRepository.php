<?php

namespace App\Repositories;

use App\Entities\Article;

class ArticleRepository extends Repository
{
    public function model()
    {
        return app(Article::class);
    }

    public function tag()
    {
        return 'article';
    }

    /**
     * 根據搜尋參數回傳符合條件的文章
     *
     * @param string $queryString 搜尋字串用來當作快取的key值
     * @param array $args 搜尋參數
     * @param string $perPage 分頁數量
     * @return Collection/Pagination
     */
    public function getByArgs($queryString = '', $args, $perPage = null)
    {
        $condition = [];

        foreach(['language', 'category_no'] as $field) {
            if(array_key_exists($field, $args) && $args[$field] != '') {
                $condition[$field] = ['$eq' => $args[$field]];
            }    
        }
        
        if(array_key_exists('type', $args) && !empty($args['type'])) {
            $condition['category_no'] = ['$eq' => $args['type']];
        }

        if(array_key_exists('s_city', $args) && !empty($args['s_city'])) {
            $condition['broadcast_area'] = ['$in' => [$args['s_city']]];
        }        

        if(array_key_exists('updated_at', $args) && !empty($args['updated_at'])) {
            $condition['updated_at'] = ['$gte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['updated_at']} 00:00:00") * 1000),
                                        '$lte' => new \MongoDB\BSON\UTCDateTime(strtotime("{$args['updated_at']} 23:59:59") * 1000)];
        }
        return cache()->tags($this->tag())->remember($this->tag().".{$queryString}", 60, function() use ($perPage,$condition) {
            $query = (count($condition) > 0)? $this->model()->whereRaw($condition)->with(['category'])->orderBy('created_at','desc') : $this->model()->with(['category'])->orderBy('created_at','desc');
            return is_null($perPage)? $query->get() : $query->paginate($perPage);
        });
    }
    
    /**
     * 檢查唯一的文章標題、語系
     *
     * @param string $category_no 文章標題的id
     * @param string $language 語系
     * @return boolean
     */
    public function checkSameArticle($category_no, $language)
    {
        $condition = [
            'category_no' => ['$eq' => $category_no],
            'language' => ['$eq' => $language],
        ];
        
        return $this->model()->whereRaw($condition)->exists();
    }
}