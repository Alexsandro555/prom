<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\Category;
use Modules\Catalog\Http\Requests\Category\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $category = Category::latest()->first();
        return [
          'categories' => Category::all(),
          'sort' => $category?$category->sort:0
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
   * @param CategoryRequest $categoryRequest
   * @return array
   */
    public function store(CategoryRequest $categoryRequest)
    {
      $request = $categoryRequest->except('_token','id');
      return ['message' => 'Успешно сохранено!', 'model' => Category::create($request)];
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
   * @param CategoryRequest $categoryRequest
   * @return array
   */
    public function update(CategoryRequest $categoryRequest)
    {
      $request = $categoryRequest->except('_token','id');
      return ['message' => 'Успешно обновлено!', 'model' => Category::where('id',$categoryRequest->id)->update($request)];
    }

  /**
   * @param Request $request
   * @return array
   */
    public function destroy(Request $request)
    {
      $category = Category::find($request->id);
      $category->delete();
      return ['message' => 'Успешно удалено!'];
    }
}
