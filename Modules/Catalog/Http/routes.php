<?php

Route::group(['middleware' => 'web', 'prefix' => 'catalog', 'namespace' => 'Modules\Catalog\Http\Controllers'], function()
{
  Route::get('/special-products', 'CatalogController@specialProducts');

  Route::get('/', 'CatalogController@index');
  Route::get('/create', 'CatalogController@create');
  Route::post('/update',
    [
      'before' => 'csrf',
      'uses' => 'CatalogController@update'
    ]);
  Route::get('/edit/{id}', 'CatalogController@edit');
  Route::delete('/delete', [
    'before' => 'csrf',
    'uses' => 'CatalogController@destroy'
  ]);
  Route::get('/attributes/{id}', 'CatalogController@attributes');
  Route::get('/attribute-values/{id}', 'CatalogController@attributeValues');
  Route::post('/save-attributes',
    [
      'before' => 'csrf',
      'uses' => 'CatalogController@saveAttributes'
    ]);

  //=========================TypeProduct============================================
  Route::get('/type-product', 'TypeProductController@index');
  Route::get('/type-product/create', 'TypeProductController@create');
  Route::post('/type-product/store',
    [
      'before' => 'csrf',
      'uses' => 'TypeProductController@store'
    ]);
  Route::post('/type-product/update',
    [
      'before' => 'csrf',
      'uses' => 'TypeProductController@update'
    ]);
  Route::delete('/type-product/delete', [
    'before' => 'csrf',
    'uses' => 'TypeProductController@destroy'
  ]);

  //=========================ТВЭД===================================================
  Route::get('/tnved', 'TnvedController@index');
  Route::post('/tnved/store',
    [
      'before' => 'csrf',
      'uses' => 'TnvedController@store'
    ]);
  Route::post('/tnved/update',
    [
      'before' => 'csrf',
      'uses' => 'TnvedController@update'
    ]);


  //=========================Category================================================
  Route::get('/categories', 'CategoryController@index');
  Route::get('/category/create', 'CategoryController@create');
  Route::post('/category/store',
    [
      'before' => 'csrf',
      'uses' => 'CategoryController@store'
    ]);
  Route::post('/category/update',
    [
      'before' => 'csrf',
      'uses' => 'CategoryController@update'
    ]);
  Route::delete('/category/delete', [
    'before' => 'csrf',
    'uses' => 'CategoryController@destroy'
  ]);


  //===========================Producer================================================
  Route::get('/producer', 'ProducerController@index');
  Route::get('/producer/create', 'ProducerController@create');
  Route::post('/producer/store',
    [
      'before' => 'csrf',
      'uses' => 'ProducerController@store'
    ]);
  Route::post('/producer/update',
    [
      'before' => 'csrf',
      'uses' => 'ProducerController@update'
    ]);
  Route::delete('/producer/delete', [
    'before' => 'csrf',
    'uses' => 'ProducerController@destroy'
  ]);


  //==========================LineProduct================================================
  Route::get('/line-product', 'LineProductController@index');
  Route::get('/line-product/create', 'LineProductController@create');
  Route::post('/line-product/store',
    [
      'before' => 'csrf',
      'uses' => 'LineProductController@store'
    ]);
  Route::post('/line-product/update',
    [
      'before' => 'csrf',
      'uses' => 'LineProductController@update'
    ]);
  Route::delete('/line-product/delete', [
    'before' => 'csrf',
    'uses' => 'LineProductController@destroy'
  ]);


  Route::get('/group', 'GroupController@index');
  Route::patch('/group', 'GroupController@store');

  //===========================Attribute================================================
  Route::get('/attribute', 'AttributeController@index');
  Route::get('/attribute/create', 'AttributeController@create');
  Route::post('/attribute/store',
    [
      'before' => 'csrf',
      'uses' => 'AttributeController@store'
    ]);
  Route::post('/attribute/update',
    [
      'before' => 'csrf',
      'uses' => 'AttributeController@update'
    ]);
  Route::post('/attribute/save',
    [
      'before' => 'csrf',
      'uses' => 'AttributeController@save'
    ]);
  Route::delete('/attribute/delete', [
    'before' => 'csrf',
    'uses' => 'AttributeController@destroy'
  ]);
  Route::get('/attribute/typeProducts', 'AttributeController@typeProducts');
  Route::get('/attribute/lineProducts', 'AttributeController@lineProducts');
  Route::get('/attribute/type-product/{id}', 'AttributeController@typeProductAttr');
  Route::get('/attribute/line-product/{id}', 'AttributeController@lineProductAttr');
  Route::get('/attribute/filtered/{id}', 'AttributeController@filteredAttr');
  Route::get('/attribute/filtered-line/{id}', 'AttributeController@filteredAttrLine');
  Route::post('/attribute/remAttrTypeProd',
    [
      'before' => 'csrf',
      'uses' => 'AttributeController@remAttrTypeProd'
    ]);
  Route::post('/attribute/remAttrLineProd',
    [
      'before' => 'csrf',
      'uses' => 'AttributeController@remAttrLineProd'
    ]);
});


