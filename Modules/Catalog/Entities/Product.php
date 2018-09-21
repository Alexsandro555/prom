<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RelationTrait;
use App\Traits\TableColumnsTrait;

class Product extends Model
{
  use SoftDeletes;

  use RelationTrait;
  use TableColumnsTrait;

  protected $dates = ['deleted_at'];

  public $form = [
    'id' => [
      'enabled' => true
    ],
    'title' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'max' => 255
      ]
    ],
    'vendor' => [
      'enabled' => true,
      'validations' => [
        'max' => 255
      ]
    ],
    'IEC' => [
      'enabled' => true,
      'validations' => [
        'max' => 15
      ]
    ],
    'price' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'regex' => '\d+.$',
        'max' => 12
      ]
    ],
    'price_amount' => [
      'enabled' => true,
      'validations' => [
        'max' => 25
      ]
    ],
    'qty' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'regex' => '^[0-9].*$',
      ]
    ],
    'sort' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
        'regex' => '^[0-9].*$',
      ]
    ],
    'description' => [
      'enabled' => true
    ],
    'onsale' => [
      'enabled' => true
    ],
    'special' => [
      'enabled' => true
    ],
    'need_order' => [
      'enabled' => true
    ],
    'active' => [
      'enabled' => true
    ],
    'type_product' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
      ]
    ],
    'line_product' => [
      'enabled' => true,
      'validations' => [
        'required' => true,
      ]
    ]
  ];

  protected $guarded = [];

  public function type_product() {
    return $this->belongsTo(TypeProduct::class);
  }


  public function line_product() {
    return $this->belongsTo(LineProduct::class);
  }

  public function attributes() {
    return $this->belongsToMany(Attribute::class)->withPivot('value','group_id');
  }

  /**
   * Получить все изображения продукта
   */
  public function files() {
    return $this->morphMany('Modules\Files\Entities\File', 'fileable');
  }

  public function setTitleAttribute($value)
  {
    $this->attributes['title'] = strip_tags($value);
  }

  public function setPriceAttribute($value)
  {
    $this->attributes['price'] = strip_tags($value);
  }

  public function setArticleAttribute($value)
  {
    $this->attributes['article'] = strip_tags($value);
  }

  public function setIECAttribute($value)
  {
    $this->attributes['IEC'] = strip_tags($value);
  }
}
