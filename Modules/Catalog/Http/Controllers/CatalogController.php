<?php

namespace Modules\Catalog\Http\Controllers;

use Modules\Catalog\Entities\LineProduct;
use Modules\Catalog\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\TypeProduct;
use Modules\Catalog\Http\Requests\Product\ProductRequest;

class CatalogController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * @param ProductService $productService
     * @return array
     */
    public function create(ProductService $productService)
    {
      return $productService->createDefault();
    }


    public function store()
    {
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
     * @param $id
     * @return array
     */
    public function edit($id)
    {
      return Product::with(['type_product','line_product'])->where('id',$id)->first();
    }

    /**
     * @param ProductRequest $productRequest
     * @return array
     */
    public function update(Request $productRequest)
    {
      // тут добавить сохранение продукта
      $arrExcept = [];
      $product = Product::find($productRequest->id);
      $relationships = $product->getRelationships();
      foreach ($relationships as $key => $relationship) {
        if($relationship["type"] == 'BelongsTo') {
          $relatinshipModel = $relationship["model"]::find($productRequest[$key]);
          $relatinshipModel->products()->save($product);
          $arrExcept[] = $key;
        }
      }
      $arrExcept[]  = '_token';
      $request = $productRequest->except($arrExcept);
      $normTitle = str_replace("/"," ",$request["title"]);
      $request["url_key"] = \Slug::make($normTitle);
      Product::where('id', $request["id"])->update($request);
      return ['message' => 'Успешное обновлено!', 'model' => Product::find($request["id"])];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request)
    {
      $product = Product::find($request->id);
      $currentFiles = File::where('fileable_id',$id)->where('fileable_type','Modules\Catalog\Entities\Product')->get();
      foreach ($currentFiles as $currentFile) {
        $currentFile->delete();
      }
      $product->delete();
      return ['message' => 'Успешно удалено!'];
    }

    /**
     * @param $id
     * @return array
     */
    public function attributes($id) {
      $product = Product::find($id);
      $lineAttributesCollection = collect();
      $typeProductsCollection = collect();
      if($product->type_product_id)
      {
        $typeProductsCollection = TypeProduct::find($product->type_product_id)->attributes;
      }
      if($product->line_product_id) {
        $lineAttributesCollection =  LineProduct::find($product->line_product_id)->attributes;
      }
      $result = $typeProductsCollection->concat($lineAttributesCollection);
      return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function attributeValues($id) {
      return Product::find($id)->attributes;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function saveAttributes(Request $request) {
      $items = $request->data;
      $productId = $request->productId;
      $arr = [];
      $attributes = json_decode($items, true);
      foreach ($attributes as $attribute) {
        $val['value'] = $attribute["value"];
        $val['group_id'] = $attribute["group_id"];
        $arr[$attribute["attribute_id"]] = $val;
      }
      $product = Product::find($productId);
      $product->attributes()->sync($arr);
      return ['message' => 'Успешно сохранено!'];
    }


    public function specialProducts() {
      return Product::with('files')->get();
    }
}
