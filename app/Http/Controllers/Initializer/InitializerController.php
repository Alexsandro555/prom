<?php

namespace App\Http\Controllers\Initializer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Whoops\Exception\ErrorException;
use App\Services\ModelService;

class InitializerController extends Controller
{
    public function fields(Builder $builder,ModelService $modelService, $name) {
      $collectionResult = collect([]);
      if(Cache::has($name)) {
        $collectionResult = Cache::get($name);
      }
      else
      {
        $model = $modelService->find($name);
        $collectionResult = $modelService->collectionGenerate($model,$name);
        Cache::add($name,$collectionResult,now()->addSeconds(10000000));
      }
      return $collectionResult;
    }
}
