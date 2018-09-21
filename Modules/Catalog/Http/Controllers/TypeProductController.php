<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\Tnved;
use Modules\Catalog\Http\Requests\TypeProduct\TypeProductRequest;
use Modules\Catalog\Entities\TypeProduct;
use Modules\Catalog\Entities\Category;
use Illuminate\Support\Facades\Cache;
use Modules\Catalog\Services\CacheService;

class TypeProductController extends Controller
{

  private $cacheService;

  public function __construct(CacheService $cacheService)
  {
    $this->cacheService = $cacheService;
  }
    /**
     * @return array
     */
    public function index()
    {
      $typeProduct = TypeProduct::latest()->first();
      return [
        "categories" => Category::all(),
        "typeProducts" => TypeProduct::all(),
        "tnveds" => Tnved::all(),
        "sort" => $typeProduct?$typeProduct->sort:0
      ];
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('catalog::create');
    }

  /**
   * @param TypeProductRequest $typeProductRequest
   * @param CacheService $cacheService
   * @return array
   */
    public function store(TypeProductRequest $typeProductRequest)
    {
      $this->cacheService->clear('product');
      $request = $typeProductRequest->except('_token','id');

      return ['message' => 'Успешно сохранено!', 'model' => TypeProduct::create($request)];
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

    /**
     * @param TypeProductRequest $typeProductRequest
     * @return array
     */
    public function update(TypeProductRequest $typeProductRequest)
    {
      $request = $typeProductRequest->except('_token','id');
      $this->cacheService->clear('product');
      return ['message' => 'Успешно обновлено!', 'model' => TypeProduct::where('id',$typeProductRequest->id)->update($request)];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request)
    {
      $typeProduct = TypeProduct::find($request->id);
      $typeProduct->delete();
      $this->cacheService->clear('product');
      return ['message' => 'Успешно удалено!'];
    }
}
