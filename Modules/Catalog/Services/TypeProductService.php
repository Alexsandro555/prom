<?php

namespace Modules\Catalog\Services;

use Modules\Catalog\Entities\Tnved;
use Modules\Catalog\Entities\TypeProduct;

class TypeProductService
{
  public function createDefault() {
    $tnved = Tnved::where('service',1)->where('active',1)->firstOrFail();
    $typeProduct = TypeProduct::where('title','default')->first();
    if(!$typeProduct) {
      return TypeProduct::create([
        'title' => 'default',
        'tnved_id' => $tnved->id,
        'sort' => TypeProduct::all()->last()->id+1
      ]);
    }
    return $typeProduct;
  }
}