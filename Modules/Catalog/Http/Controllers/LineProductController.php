<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\LineProduct;
use Modules\Catalog\Http\Requests\LineProduct\LineProductRequest;
use Modules\Catalog\Entities\TypeProduct;
use Modules\Catalog\Entities\Producer;
use Illuminate\Http\Request;
use Modules\Catalog\Services\CacheService;

class LineProductController extends Controller
{

  private $cacheService;

  public function __construct(CacheService $cacheService)
  {
    $this->cacheService = $cacheService;
  }


    /**
     * @return mixed
     */
    public function index()
    {
      $lineProduct = LineProduct::latest()->first();
      return [
        "typeProducts" => TypeProduct::all(),
        "producers" => Producer::all(),
        "lineProducts" => LineProduct::all(),
        "sort" => $lineProduct?$lineProduct->sort:0
      ];
    }

    /**
     * @return array
     */
    public function create()
    {
      return [
        "typeProducts" => TypeProduct::all(),
        "producers" => Producer::all(),
        "sort" => TypeProduct::all()->last()->id+1
      ];
    }

    /**
     * @param LineProductRequest $lineProductRequest
     * @return array
     */
    public function store(LineProductRequest $lineProductRequest)
    {
      $this->cacheService->clear('product');
      $request = $lineProductRequest->except('_token','id');
      return ['message' => 'Успешно сохранено!', 'model' => LineProduct::create($request)];
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('catalog::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('catalog::edit');
    }

    public function update(LineProductRequest $lineProductRequest)
    {
      $this->cacheService->clear('product');
      $request = $lineProductRequest->except('_token','id');
      return ['message' => 'Успешно обновлено!', 'model' => LineProduct::where('id',$lineProductRequest->id)->update($request)];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request)
    {
      $this->cacheService->clear('product');
      $lineProduct = LineProduct::find($request->id);
      $lineProduct->delete();
      return ['message' => 'Успешно удалено!'];
    }
}
