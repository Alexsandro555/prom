<?php

namespace Modules\Catalog\Services;
use Illuminate\Support\Facades\Cache;

class CacheService
{
  public function clear($name) {
    if(Cache::has($name)) {
      Cache::pull($name);
    }
  }
}