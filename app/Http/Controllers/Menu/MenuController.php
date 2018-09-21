<?php

namespace App\Http\Controllers\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Catalog\Entities\Category;

class MenuController extends Controller
{
  public function index() {
    return Category::with('type_products.producer_type_products.producer')->get();
  }
}
