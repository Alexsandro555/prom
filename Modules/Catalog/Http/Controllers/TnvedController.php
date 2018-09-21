<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\Tnved;
use Modules\Catalog\Http\Requests\Tnved\TnvedRequest;

class TnvedController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
      return Tnved::all();
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
   * @param TnvedRequest $tnvedRequest
   * @return array
   */
    public function store(TnvedRequest $tnvedRequest)
    {
      $request = $tnvedRequest->except('_token');
      return ['message' => 'Успешно сохранено!', 'model' => Tnved::create($request)];
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('catalog::show');
    }


    public function edit()
    {

    }

    /**
     * @param TnvedRequest $tnvedRequest
     * @return array
     */
    public function update(TnvedRequest $tnvedRequest)
    {
      $request = $tnvedRequest->except('_token');
      return ['message' => 'Успешно обновлено!', 'model' => Tnved::where('code',$tnvedRequest->code)->update($request)];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request)
    {
      $tnved = Tnved::find($request->code);
      $tnved->delete();
      return ['message' => 'Успешно удалено!'];
    }
}
