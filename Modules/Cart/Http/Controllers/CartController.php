<?php

namespace Modules\Cart\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\Product;
use Cart;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('cart::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('cart::create');
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function store(Request $request)
    {
      $id = $request->id;
      $product = Product::with('files')->find($id);
      if(!$product) {
        throw new \Exception('Заданная позиция не была найдена');
      }
      $filename = "";
      foreach($product->files as $file)
      {
        foreach ($file->config as $filesItem)
        {
          foreach ($filesItem as $key=>$fileItem)
          {
            if($key === "s-medium")
            {
              $filename = $fileItem["filename"];
              break;
            }
          }
        }
      }
      Cart::add($product->id, $product->title, 1, $product->price,['article'=>$product->article, 'slug'=>$product->url_key, 'filename'=>$filename!=""?$filename:"no-image.png"]);
      $total = Cart::subtotal();
      $count = Cart::count();
      return ["total"=>$total,"count"=>$count];
    }

    /**
     * @return array
     */
    public function current() {
      $total = Cart::subtotal();
      $count = Cart::count();
      return ["total"=>$total,"count"=>$count];
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('cart::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('cart::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
