<?php
namespace App\Observers;

use \Cache;
 
abstract class AbstractObserver {
 
    protected function clearCacheTags($tags) {
        Cache::tags($tags)->flush();
    }
 
    protected function clearCacheSections($section) {
        Cache::section($section)->flush();
    }
    
    // 新增
    abstract public function saved($model);
    abstract public function saving($model);
    abstract public function created($model);
    abstract public function creating($model);
    // 更新
    // abstract public function saved($model);
    // abstract public function saving($model);
    abstract public function updated($model);
    abstract public function updating($model);
    // 刪除 
    abstract public function deleted($model);
    abstract public function deleting($model);
}