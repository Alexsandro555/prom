<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Основыне страницы сайта
Route::get('/', ['uses' => 'main\MainController@index', 'as' => 'main']);
Route::get('/catalog/{slug}', ['uses' => 'main\MainController@catalogTypes', 'as' => 'catalog']);

Route::get('/figure', function() {
  $figure = new App\Classes\VibratorsFigureClass;
  $figure->make();
});



Route::get('/login', ['uses' => 'main\MainController@login', 'as' => 'login']);
Route::get('/test', function () {
  phpinfo();
});
Route::get('authenticated', 'main\MainController@authenticated');
Route::get('/admin', ['uses' => 'Admin\AdminController@index', 'as' => 'admin'])->middleware('admin');
Route::get('/demo', 'main\MainController@mas');

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('exit', function() {
  Auth::logout();
});

Route::get('/initializer/fields/{name}', 'Initializer\InitializerController@fields');

Route::get('/left-menu', 'Menu\MenuController@index');

Route::get('/files', function() {
  $name = 'product';
  $arrResult = [];
  $tableName = $name.'s';
  $columns = Schema::getColumnListing($tableName);
  foreach ($columns as $column) {
    $arr['type'] = Schema::getColumnType($tableName,$column);
    $arr['label'] = \DB::select(\DB::raw("SELECT COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_NAME = '".$tableName."' AND COLUMN_NAME='".$column."'"))[0]->COLUMN_COMMENT;
    $arrResult[$column] = $arr;
  }
  $directories = \Illuminate\Support\Facades\File::directories(base_path().'/Modules');
  $form = [];
  foreach ($directories as $directory) {
    $dirModule = substr($directory, strripos($directory, '/')+1);
    $namespace = "Modules\\".$dirModule."\\Entities\\";
    if(class_exists($namespace.ucfirst($name))) {
      $modelName = $namespace.ucfirst($name);
      $model = new $modelName;
      $form = $model->form;
      $relationships = $model->getRelationships();
      $arrResult['relationships'] = $relationships;
    }
  }
  $filteredResult = [];
  foreach ($form as $item) {
    if(array_key_exists($item, $arrResult)) {
      $filteredResult[$item] = $arrResult[$item];
    }
  }
  $filteredResult['relationships'] = $arrResult['relationships'];
  dd($filteredResult);
});

// Изображения продукта
Route::get('product-images/{id}', ['uses' => 'main\MainController@images', 'as' => 'product-images']);


Route::get('/{slug}', ['uses' => 'main\MainController@catalogTypes', 'as'=> 'catalog-products']);


