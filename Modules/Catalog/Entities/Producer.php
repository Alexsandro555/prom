<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RelationTrait;

class Producer extends Model
{
  use SoftDeletes;

  use RelationTrait;

  protected $fillable = [
    'id',
    'title',
    'sort'
  ];

  protected $dates = ['deleted_at'];

 /*public function type_products()
  {
    return $this->belongsToMany('Modules\Catalog\Entities\TypeProduct');
  }*/
 public function line_products() {
   return $this->hasMany(LineProduct::class);
 }

  public function products() {
    return $this->hasMany('Modules\Catalog\Entities\Product');
  }
}
