<?php

Route::group(['middleware' => 'web', 'prefix' => 'banner', 'namespace' => 'Modules\Banner\Http\Controllers'], function()
{
    Route::get('/', 'BannerController@index');
    Route::post('/save', [
      'before' => 'csrf',
      'uses' => 'BannerController@store'
    ]);
});
