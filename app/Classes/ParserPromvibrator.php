<?php
/**
 * Created by PhpStorm.
 * User: alexsandro
 * Date: 14.02.18
 * Time: 10:55
 */

namespace App\Classes;

use App\Product;

class ParserPromvibrator
{
  public function make() {
    set_time_limit(60);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36");
    curl_setopt($ch, CURLOPT_REFERER, "http://www.google.ru");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $products = Product::with('type_product')->get();
    $arrProducts = [];
    foreach ($products as $product) {
      $slug = $product->type_product->url_key;
      $id = $product->old_id;
      $url = "http://www.promvibrator.ru/".$slug.".php?id=".$id;
      curl_setopt($ch, CURLOPT_URL, $url);
      $data = curl_exec($ch);
      /* поиск изображений
      preg_match_all('/<div class="product-img-small"><img src="\/images\/(.*?)"/',$data, $matches);
      foreach ($matches[1] as $match) {
        $item['id'] = $product->id;
        $item['image'] = $match;
        $arrProducts[] = $item;
      } */
      preg_match_all('/<strong>(.*?)<\/strong><div class="product-select-block">/',$data, $matches);
      foreach ($matches[1] as $match) {

        $match = 'Вибратор';
        $str = '/<strong>'.$match.'<\/strong>(.*?)<\/div><div class="product-select"/';
        $str = '/<(.*?)<\/div><div class="product-select">/';
        preg_match_all($str,$data, $matches);
        dd($matches);
      }
    }
    curl_close($ch);
    dd($arrProducts);
    
  }
}