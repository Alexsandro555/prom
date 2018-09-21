<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Catalog\Http\Requests\Attribue\AttributeRequest;
use Modules\Catalog\Entities\Attribute;
use Modules\Catalog\Entities\TypeProduct;
use Modules\Catalog\Entities\LineProduct;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Group;

class AttributeController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
      $attribute = Attribute::latest()->first();
      return [
        "attributes" => Attribute::all(),
        "groups" => Group::all(),
        "sort" => $attribute?$attribute->sort:0
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
   * @param AttributeRequest $attributeRequest
   * @return array
   */
    public function store(AttributeRequest $attributeRequest)
    {
      $request = $attributeRequest->except('_token','id');
      return ['message' => 'Успешно сохранено!', 'model' => Attribute::create($request)];
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
   * @param AttributeRequest $attributeRequest
   * @return array
   */
    public function update(AttributeRequest $attributeRequest)
    {
      $request = $attributeRequest->except('_token','id');
      return ['message' => 'Успешно обновлено!', 'model' => Attribute::where('id',$attributeRequest->id)->update($request)];
    }

  /**
   * @param Request $request
   * @return array
   */
    public function destroy(Request $request)
    {
      $attribute = Attribute::find($request->id);
      $attribute->delete();
      return ['message' => 'Успешно удалено!'];
    }



    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function lineProducts() {
      return TypeProduct::with('line_products')->orderBy('sort', 'asc')->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function typeProductAttr($id) {
      return TypeProduct::find($id)->attributes;
    }

    /**
     * Get Attributes
     * @return Arr
     */
    public function lineProductAttr($id)
    {
      return LineProduct::find($id)->attributes;
    }

    public function filteredAttr($id) {
      $attributes = Attribute::all();
      $arrAttributes = [];
      foreach ($attributes as $attribute) {
        $arrAttributes[$attribute["id"]] = $attribute["title"];
      }
      $typeProduct = TypeProduct::find($id);
      if($typeProduct) {
        $arr2 = [];
        foreach ($typeProduct->attributes as $attribute) {
          $arr2[$attribute["id"]] = $attribute["title"];
        }
        $arrAttributes = array_diff($arrAttributes,$arr2);

        foreach($typeProduct->line_products as $lineProduct) {
          if($lineProduct) {
            $arr = [];
            foreach ($lineProduct->attributes as $attribute) {
              $arr[$attribute["id"]] = $attribute["title"];
            }
            $arrAttributes = array_diff($arrAttributes,$arr);
          }
        }
      }
      $arrT = [];
      foreach ($arrAttributes as $key=>$arr) {
        $temp['id'] = $key;
        $temp['title'] = $arr;
        $arrT[] = $temp;
      }
      return $arrT;
    }

    /**
     * Get Attributes
     */
    public function filteredAttrLine($id)
    {
      $attributes = Attribute::all();
      $arrAttributes = [];
      foreach ($attributes as $attribute) {
        $arrAttributes[$attribute["id"]] = $attribute["title"];
      }
      $lineProduct = LineProduct::find($id);
      if($lineProduct) {
        $arr2 = [];
        foreach ($lineProduct->attributes as $attribute) {
          $arr2[$attribute["id"]] = $attribute["title"];
        }
        $arrAttributes = array_diff($arrAttributes,$arr2);

        $typeProduct = $lineProduct->type_product;
        if($typeProduct) {
          $arr = [];
          foreach ($typeProduct->attributes as $attribute) {
            $arr[$attribute["id"]] = $attribute["title"];
          }
          $arrAttributes = array_diff($arrAttributes,$arr);
        }
      }
      $arrT = [];
      foreach ($arrAttributes as $key=>$arr) {
        $temp['id'] = $key;
        $temp['title'] = $arr;
        $arrT[] = $temp;
      }
      return $arrT;
    }

  /**
   * @param Request $request
   * @return array
   */
  public function save(Request $request) {
    $typeProductId = $request->typeProductId;
    $lineProductId = $request->lineProductId;

    if($lineProductId) {
      foreach ($request->attr as $attribute) {
        DB::table('attributables')->insert([
          'attribute_id' => $attribute["id"],
          'attributable_id' => $lineProductId,
          'attributable_type' => 'Modules\Catalog\Entities\LineProduct'
        ]);
      }
      return ['message' => 'Успешно сохранено!'];
    }

    if($typeProductId) {
      foreach ($request->attr as $attribute)
      {
        DB::table('attributables')->insert([
          'attribute_id' => $attribute["id"],
          'attributable_id' => $typeProductId,
          'attributable_type' => 'Modules\Catalog\Entities\TypeProduct'
        ]);
      }
      return ['message' => 'Успешно сохранено!'];
    }
  }


  public function remAttrTypeProd(Request $request) {
    $attr = $request->attr;
    $type_product_id = $request->type_product_id;
    foreach ($attr as $item) {
      DB::table('attributables')->where('attribute_id', $item)->where('attributable_type', 'Modules\Catalog\Entities\TypeProduct')->where('attributable_id',$type_product_id)->delete();
    }
  }

  public function remAttrLineProd(Request $request) {
    $attr = $request->attr;
    $producer_type_product_id = $request->producer_type_product_id;
    foreach ($attr as $item) {
      DB::table('attributables')->where('attribute_id', $item)->where('attributable_type', 'Modules\Catalog\Entities\LineProduct')->where('attributable_id',$producer_type_product_id)->delete();
    }
  }
}
