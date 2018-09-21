<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
  use SoftDeletes;

  protected $table = 'categories';
  protected $fillable = [
    'id',
    'title',
    'sort',
    'description'
  ];

  protected $dates = ['deleted_at'];

  public function type_products() {
    return $this->hasMany(TypeProduct::class);
  }

  /**
   * Получить все изображения категории
   */
  public function files() {
    return $this->morphMany('Modules\Files\Entities\File', 'fileable');
  }
}
