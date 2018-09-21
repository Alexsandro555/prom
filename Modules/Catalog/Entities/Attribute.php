<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'sort',
    'title',
    'alias',
    'group_id'
  ];

  public function products() {
    return $this->belongsToMany(Product::class)->withPivot('value');;
  }

  public function typeProducts() {
    return $this->morphedByMany(TypeProduct::class, 'attributable');
  }

  public function lineProducts() {
    return $this->morphedByMany(LineProduct::class, 'attributable');
  }

  public function group() {
    return $this->belongsTo(Group::class);
  }
}
