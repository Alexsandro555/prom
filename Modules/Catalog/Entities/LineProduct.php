<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RelationTrait;

class LineProduct extends Model
{
  use RelationTrait;

  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'id',
    'title',
    'sort',
    'producer_id',
    'type_product_id',
    'url_key'
  ];

  protected $guarded = [];

  public function type_product() {
    return $this->belongsTo(TypeProduct::class);
  }

  public function producer() {
    return $this->belongsTo(Producer::class);
  }

  public function products() {
    return $this->hasMany(Product::class);
  }

  /**
   * Получить все изображения категории
   */
  public function files() {
    return $this->morphMany('Modules\Files\Entities\File', 'fileable');
  }

  public function attributes() {
    return $this->morphToMany('Modules\Catalog\Entities\Attribute', 'attributable');
  }
}
