<?php
/**
 * Created by PhpStorm.
 * User: alexsandro
 * Date: 10.04.18
 * Time: 17:18
 */

namespace Modules\Catalog\Services;

use Modules\Catalog\Entities\Producer;

class ProducerService
{
  public function createDefault() {
    $producer = Producer::where('title','default')->first();
    if(!$producer) {
      return Producer::create([
        'title' => 'default',
        'sort' => Producer::all()->last()->id+1
      ]);
    }
    return $producer;
  }
}