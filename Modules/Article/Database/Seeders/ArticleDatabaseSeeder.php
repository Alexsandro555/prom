<?php

namespace Modules\Article\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Article\Entities\Article;

class ArticleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $mainArticles = DB::connection('mysql2')->table('main')->get();
        foreach ($mainArticles as $mainArticle) {
          $news = new Article;
          $news->title = $mainArticle->title;
          $news->url_key = $mainArticle->alt_name;
          $description = str_replace('http://www.promvibrator.ru/images','/storage',$mainArticle->description);
          $news->content = $description;
          $news->news = true;
          $news->save();
        }
        // $this->call("OthersTableSeeder");
    }
}
