<?php

namespace App\Http\Controllers\main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\TypeProduct;
use Modules\Catalog\Entities\Group;
use App\Classes\Breadcrumb;
use Illuminate\Support\Collection;

class MainController extends Controller
{
  public function index() {
    // для меню
    $typeProducts = TypeProduct::all();
    // специальное предложение по товарам
    $products = Product::with(['files','attributes','type_product'])->where('active',1)->where('special',1)->get();
    return view('main.index',compact('products','typeProducts'));
  }


  public function catalogTypes($slug, Request $request) {
    $breadcrumbs = new Collection();
    // Получение детальной карточки товара
    $id = $request->id;
    if($id) {
      $slug = str_replace('.php','',$slug);
      $product = Product::with(['files','attributes.group','line_product', 'type_product'])->whereHas('type_product',function($query) use ($slug) {
        $query->where('url_key',$slug);
      })->where('old_id',$id)->firstOrFail();
      $productId = $product->id;

      $typeProduct = TypeProduct::with('line_products')->find($product->type_product_id);
      $breadcrumbs->push(new Breadcrumb("Главная страница", "/"));
      $breadcrumbs->push(new Breadcrumb($product->type_product->title, $product->type_product->url_key));
      if($product->line_product)
      {
        $breadcrumbs->push(new Breadcrumb($product->line_product->title, $product->type_product->url_key));
      }
      $breadcrumbs->push(new Breadcrumb($product->title, $product->url_key));
      return view('main.detail', compact('product','typeProduct','breadcrumbs'));
    }
    // конец получения детальной карточки товара

    // получение продуктов заданной категории типа продукта
    $products = Product::with(['files','attributes','type_product'])->whereHas('type_product',function($query) use ($slug) {
      $query->where('url_key',$slug);
    })->where('active',1)->paginate(10);

    // получение продуктов заданной категории для линейки продукции если тип продукции с таким slug не был найден
    if($products->count() === 0) {
      $products = Product::with(['files','attributes','line_product'])->whereHas('line_product', function($query) use ($slug) {
        $query->where('url_key',$slug);
      })->where('active',1)->paginate(10);
      // Получение продуктов с заданным атрибутов - еще потребуется добавить с заданной линейкой продукции
      if($products->count() === 0) {
        $products = Product::with('attributes')->whereHas('attributes', function($query) use ($slug) {
          $query->where('alias',$slug);
        })->where('active',1)->get();
        if($products->count() === 0) {
          abort(404);
        }
        // линейки имеющие заданный атрибут
        $lineProduct = LineProduct::with(['attributes'])->whereHas('attributes', function($query) use ($slug) {
          $query->where('alias',$slug);
        })->firstOrFail();
        // если линеек с заданным атрибутом нет - то проверяем тип продукции
        if($lineProduct->count() === 0) {
          $typeProduct = TypeProduct::with(['attributes','line_products'])->whereHas('attributes', function($query) use ($slug) {
            $query->where('alias',$slug);
          })->FirsOrFail();
        }
        else {
          $typeProduct = TypeProduct::with(['attributes','line_products'])->find($lineProduct->type_product_id);
        }
        $attribute = Attribute::where('alias',$slug)->FirsOrFail();
        $breadcrumbs->push(new Breadcrumb("Главная страница", "/"));
        $breadcrumbs->push(new Breadcrumb($typeProduct->title, $typeProduct->url_key));
        $breadcrumbs->push(new Breadcrumb($attribute->title, $attribute->alias));
        return view('main.catalog', compact('products','typeProduct','breadcrumbs'));
      }
      $lineProduct = LineProduct::where('url_key',$slug)->first();
      $idTypeProduct = $lineProduct->type_product_id;
      $typeProduct =  TypeProduct::with('line_products')->whereHas('line_products',function($query) use($slug) {
        $query->where('url_key',$slug);
      })->first();
      $breadcrumbs->push(new Breadcrumb("Главная страница", "/"));
      $breadcrumbs->push(new Breadcrumb($typeProduct->title, $typeProduct->url_key));
      $breadcrumbs->push(new Breadcrumb($lineProduct->title, $slug));
    }
    else {
      // получение информации для заданной категории типа продукции
      $typeProduct = TypeProduct::with('line_products')->where('url_key',$slug)->first();
      $breadcrumbs->push(new Breadcrumb("Главная страница", "/"));
      $breadcrumbs->push(new Breadcrumb($typeProduct->title, $slug));
    }
    return view('main.catalog', compact('products','typeProduct','breadcrumbs'));
  }

  public function login() {
    return view('main.login');
  }

  public function mas() {
    return view('welcome');
  }

  public function authenticated(Request $request) {
    $user = $request->user();
    if($user) {
      //if($user->admin == 1) return $user->name;
      return $user->name;
    }
    return null;
  }

  public function detail($slug) {
    $product = Product::with(['files' => function($query) {
      $query->with('typeFile')->whereHas('typeFile', function($query) {
        $query->where('name','detailimage');
      })->orderBy('updated_at','desc');
    },'attributes.group'])->where('url_key',$slug)->first();
    return view('main.detail',compact('product'));
  }

  public function catalog($id) {

  }
}
