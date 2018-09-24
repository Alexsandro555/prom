<?php

namespace Modules\Article\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Files\Entities\File;

class Article extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'id',
    'title',
    'url_key',
    'content',
    'news'
  ];

  public function files() {
    return $this->morphMany(File::class, 'fileable');
  }

  public function setTitleAttribute($value) {
    $this->attributes['title'] = strip_tags($value);
  }
}
