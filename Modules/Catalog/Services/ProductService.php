<?php
/**
 * Created by PhpStorm.
 * User: alexsandro
 * Date: 02.11.17
 * Time: 9:28
 */

namespace Modules\Catalog\Services;

use Modules\Catalog\Entities\Product;

class ProductService
{
  public function createDefault() {
    $product = Product::where('url_key','po-umolchaniyu')->first();
    if(!$product) {
      $product = new Product;
      $product->title = 'По умолчанию';
      $product->url_key = 'po-umolchaniyu';
      $product->price = 0;
      $product->sort = 1;
      $product->qty = 1;
      $product->active = 1;
      $product->save();
    }
    return $product;
  }
}