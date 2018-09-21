<?php

namespace Modules\Banner\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Banner\Entities\Banner;

class BannerController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Banner::all();
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('banner::create');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
      $banner = new Banner;
      $banner->title = $request->title;
      $banner->description = $request->description;
      $banner->save();
      return ['message' => 'Успешно сохранено!'];
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('banner::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('banner::edit');
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
