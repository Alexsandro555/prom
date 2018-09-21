<?php

namespace Modules\Catalog\Entities;

use Modules\Catalog\Entities\AttributeProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RelationTrait;
use App\Traits\TableColumnsTrait;

class Group extends Model
{
  use SoftDeletes;
  use RelationTrait;
  use TableColumnsTrait;

  public $form = [
    'id' => [
      'enabled' => true
    ],
    'title' => ['enabled' => true,
      'validations' => [
        'required' => true,
        'max' => 255
      ]
    ]
  ];

  protected $guarded = [];

  protected $dates = ['deleted_at'];

  public function attribute_product() {
    return $this->hasMany(AttributeProduct::class);
  }
}
