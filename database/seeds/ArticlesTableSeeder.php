<?php

use Illuminate\Database\Seeder;

use App\Entities\Article;
use App\Entities\Category;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectID;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::truncate();
        Category::truncate();

        Category::insert([
            [
                'no' => '1',
                'name' => '小提醒',
                'updated_at' => new UTCDateTime(time() * 1000),
                'created_at' => new UTCDateTime(time() * 1000),
            ],
            [
                'no' => '2',
                'name' => '费率及营运规则说明',
                'updated_at' => new UTCDateTime(time() * 1000),
                'created_at' => new UTCDateTime(time() * 1000),
            ],
            [
                'no' => '3',
                'name' => '服务条款',
                'updated_at' => new UTCDateTime(time() * 1000),
                'created_at' => new UTCDateTime(time() * 1000),
            ],
            [
                'no' => '4',
                'name' => '会员同意书',
                'updated_at' => new UTCDateTime(time() * 1000),
                'created_at' => new UTCDateTime(time() * 1000),
            ],
        ]);

        $category_nos = Category::get()->pluck('no')->toArray();
        factory(Article::class, 10)->create()->each(function($article) use ($category_nos) {
            shuffle($category_nos);
            $category_no = array_pop($category_nos);
            $article->category_no = $category_no;
            $article->save();
        });
    }
}
