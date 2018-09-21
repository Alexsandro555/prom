<?php

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = [];

    /**
     * Получить все изображения продукта
     */
    public function files() {
      return $this->morphMany('Modules\Files\Entities\File', 'fileable');
    }
}
