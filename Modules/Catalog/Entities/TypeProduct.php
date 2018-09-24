<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RelationTrait;

class TypeProduct extends Model
{
  use SoftDeletes;

  use RelationTrait;

  protected $fillable = [
    'id',
    'title',
    'sort',
    'tnved_id',
    'category_id',
    'description',
    'url_key'
  ];

  protected $dates = ['deleted_at'];

  public function products() {
    return $this->hasMany(Product::class);
  }

  public function tnveds() {
    return $this->belongsTo(Tnved::class);
  }

  public function line_products() {
    return $this->hasMany(LineProduct::class);
  }

  /*public function files() {
    return $this->morphMany('Leader\UploadFile\Models\File', 'fileable');
  }*/

  public function attributes() {
    return $this->morphToMany(Attribute::class, 'attributable');
  }

  public function category() {
    return $this->belongsTo(Category::class);
  }
}
