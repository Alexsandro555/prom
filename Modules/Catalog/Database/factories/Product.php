<?php

use Faker\Generator as Faker;

$factory->define(Modules\Catalog\Entities\Product::class, function (Faker $faker) {
    return [
      'title' => $faker->name,
      'url_key' => $faker->slug,
      'price' => $faker->randomFloat(NULL, 100,10000),
      'description' => $faker->paragraph(),
      'qty' => 1,
      'active' => 1,
      'sort' => 1,
      'onsale' => 1,
      'special' => 1,
      'need_order' => 1,
      'type_product_id' => 1,
      'producer_id' => 1,
      'producer_type_product_id' => 1
    ];
});
