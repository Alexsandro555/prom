<?php

Route::group(['middleware' => 'web', 'prefix' => 'files', 'namespace' => 'Modules\Files\Http\Controllers'], function()
{
    Route::get('/', 'FilesController@index');
    Route::post('/upload',
      [
        'before' => 'csrf',
        'uses' => 'FilesController@store'
      ]);
    Route::post('/image-wysiwyg-upload',
      [
        'before' => 'csrf',
        'uses' => 'FilesController@storeWysiwyg'
      ]);
    Route::post('/get-images', [
      'before' => 'csrf',
      'uses' => 'FilesController@getImages'
    ]);
    Route::get('/delete-file/{id}', 'FilesController@deleteFile');

    Route::get('/product-image/{id}', 'FilesController@productImage');


    // манипуляция типом файла
    Route::get('/type-files', 'TypeFileController@index');
    Route::post('/type-files/add',
      [
        'before' => 'csrf',
        'uses' => 'TypeFileController@create'
      ]);
    Route::post('/type-files/add-format',
      [
        'before' => 'csrf',
        'uses' => 'TypeFileController@addFormat'
      ]);
    Route::post('/type-files/del-format',
      [
        'before' => 'csrf',
        'uses' => 'TypeFileController@delFormat'
      ]);
    Route::post('/type-files/update',
      [
        'before' => 'csrf',
        'uses' => 'TypeFileController@update'
      ]);
});
