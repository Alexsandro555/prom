<?php
/**
 * Created by PhpStorm.
 * User: alexsandro
 * Date: 16.02.18
 * Time: 17:15
 */

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Modules\Files\Entities\File;
use Modules\Catalog\Entities\Product;

class Photos
{
  private $connection = 'mysql2';

  public function make() {
    // Пневматические вибраторы
    $photos = DB::connection($this->connection)->table('arsenal_photos')->where('tabl','pneumatic_vibrators')->get();
    foreach ($photos as $photo) {
      // тип файла original
      $manager = new ImageManager();
      $storageFile = $manager->make( storage_path('app/public/'.$photo->photo));
      $item["size"] = $storageFile->filesize();
      $item["filename"] = $photo->photo;
      $items["original"] = $item;

      // тип файла main
      $typeFile["name"] = "main";
      $typeFile["width"] = "460";
      $typeFile["height"] = "308";
      $typeFile["absolute"] = false;
      $storageFile = $manager->make( storage_path('app/public/'.$photo->mediumphoto));
      $item["size"] = $storageFile->filesize();
      $item["width"] = $storageFile->width();
      $item["height"] = $storageFile->height();
      $item["filename"] = $photo->mediumphoto;
      $item["resize"] = $typeFile;
      $items["main"] = $item;
      // тип файла medium
      $typeFile["name"] = "medium";
      $typeFile["width"] = "250";
      $typeFile["height"] = "160";
      $typeFile["absolute"] = false;
      $item["resize"] = $typeFile;
      $items["medium"] = $item;

      // тип файла s-medium
      $typeFile["name"] = "s-medium";
      $typeFile["width"] = "180";
      $typeFile["height"] = "100";
      $typeFile["absolute"] = false;
      $item["resize"] = $typeFile;
      $items["s-medium"] = $item;

      // тип файла small
      $typeFile["name"] = "small";
      $typeFile["width"] = "90";
      $typeFile["height"] = "40";
      $typeFile["absolute"] = false;
      $manager = new ImageManager();
      $storageFile = $manager->make( storage_path('app/public/'.$photo->miniphoto));
      unlink(storage_path('app/public/'.$photo->miniphoto));
      $resultFile = $storageFile->resize(90,40,function($constraing) {
        $constraing->aspectRatio();
        $constraing->upsize();
      })->save(storage_path('app/public/'.$photo->miniphoto));
      $item["size"] = $resultFile->filesize();
      $item["width"] = $resultFile->width();
      $item["height"] = $resultFile->height();
      $item["filename"] = $photo->miniphoto;
      $item["resize"] = $typeFile;
      $items["small"] = $item;

      $config["files"] = $items;

      $products = Product::whereHas('type_product', function ($query) {
        $query->where('title','Пневматические вибраторы');
      })->where('typeid',$photo->remoteid)->get();
      foreach ($products as $product) {
        $file = new File;
        $file->fileable_id = $product->id;
        $file->fileable_type = Product::class;
        $file->original_name = $photo->photo;
        $file->config = $config;
        $file->type_file_id = 2;
        $file->remoteid = $photo->remoteid;
        $file->save();
      }

      $products = Product::whereHas('type_product', function ($query) {
        $query->where('title','Системы виброаэрации');
      })->where('old_id',$photo->remoteid)->get();
      foreach ($products as $product) {
        $file = new File;
        $file->fileable_id = $product->id;
        $file->fileable_type = Product::class;
        $file->original_name = $photo->photo;
        $file->config = $config;
        $file->type_file_id = 2;
        $file->remoteid = $photo->remoteid;
        $file->save();
      }
    }



    // Пневматические вибраторы
    $photos = DB::connection($this->connection)->table('arsenal_photos')->where('tabl','pneumatic_vibrators_types')->get();
    foreach ($photos as $photo) {
      // тип файла original
      $manager = new ImageManager();
      $storageFile = $manager->make( storage_path('app/public/'.$photo->photo));
      $item["size"] = $storageFile->filesize();
      $item["filename"] = $photo->photo;
      $items["original"] = $item;

      // тип файла main
      $typeFile["name"] = "main";
      $typeFile["width"] = "460";
      $typeFile["height"] = "308";
      $typeFile["absolute"] = false;
      $storageFile = $manager->make( storage_path('app/public/'.$photo->mediumphoto));
      $item["size"] = $storageFile->filesize();
      $item["width"] = $storageFile->width();
      $item["height"] = $storageFile->height();
      $item["filename"] = $photo->mediumphoto;
      $item["resize"] = $typeFile;
      $items["main"] = $item;
      // тип файла medium
      $typeFile["name"] = "medium";
      $typeFile["width"] = "250";
      $typeFile["height"] = "160";
      $typeFile["absolute"] = false;
      $item["resize"] = $typeFile;
      $items["medium"] = $item;

      // тип файла s-medium
      $typeFile["name"] = "s-medium";
      $typeFile["width"] = "180";
      $typeFile["height"] = "100";
      $typeFile["absolute"] = false;
      $item["resize"] = $typeFile;
      $items["s-medium"] = $item;

      // тип файла small
      $typeFile["name"] = "small";
      $typeFile["width"] = "90";
      $typeFile["height"] = "40";
      $typeFile["absolute"] = false;
      $manager = new ImageManager();
      $storageFile = $manager->make( storage_path('app/public/'.$photo->miniphoto));
      unlink(storage_path('app/public/'.$photo->miniphoto));
      $resultFile = $storageFile->resize(90,40,function($constraing) {
        $constraing->aspectRatio();
        $constraing->upsize();
      })->save(storage_path('app/public/'.$photo->miniphoto));
      $item["size"] = $resultFile->filesize();
      $item["width"] = $resultFile->width();
      $item["height"] = $resultFile->height();
      $item["filename"] = $photo->miniphoto;
      $item["resize"] = $typeFile;
      $items["small"] = $item;

      $config["files"] = $items;

      $products = Product::whereHas('type_product', function ($query) {
        $query->where('title','Пневматические вибраторы');
      })->where('typeid',$photo->remoteid)->get();
      foreach ($products as $product) {
        $file = new File;
        $file->fileable_id = $product->id;
        $file->fileable_type = Product::class;
        $file->original_name = $photo->photo;
        $file->config = $config;
        $file->type_file_id = 2;
        $file->remoteid = $photo->remoteid;
        $file->save();
      }

      $products = Product::whereHas('type_product', function ($query) {
        $query->where('title','Системы виброаэрации');
      })->where('old_id',$photo->remoteid)->get();
      foreach ($products as $product) {
        $file = new File;
        $file->fileable_id = $product->id;
        $file->fileable_type = Product::class;
        $file->original_name = $photo->photo;
        $file->config = $config;
        $file->type_file_id = 2;
        $file->remoteid = $photo->remoteid;
        $file->save();
      }
    }



    // Площадочные
    $photos = DB::connection($this->connection)->table('arsenal_photos')->where('tabl','vibrators_types')->get();
    foreach ($photos as $photo) {
      // тип файла original
      $manager = new ImageManager();
      $storageFile = $manager->make( storage_path('app/public/'.$photo->photo));
      $item["size"] = $storageFile->filesize();
      $item["filename"] = $photo->photo;
      $items["original"] = $item;

      // тип файла main
      $typeFile["name"] = "main";
      $typeFile["width"] = "460";
      $typeFile["height"] = "308";
      $typeFile["absolute"] = false;
      $storageFile = $manager->make( storage_path('app/public/'.$photo->mediumphoto));
      $item["size"] = $storageFile->filesize();
      $item["width"] = $storageFile->width();
      $item["height"] = $storageFile->height();
      $item["filename"] = $photo->mediumphoto;
      $item["resize"] = $typeFile;
      $items["main"] = $item;
      // тип файла medium
      $typeFile["name"] = "medium";
      $typeFile["width"] = "250";
      $typeFile["height"] = "160";
      $typeFile["absolute"] = false;
      $item["resize"] = $typeFile;
      $items["medium"] = $item;

      // тип файла s-medium
      $typeFile["name"] = "s-medium";
      $typeFile["width"] = "180";
      $typeFile["height"] = "100";
      $typeFile["absolute"] = false;
      $item["resize"] = $typeFile;
      $items["s-medium"] = $item;

      // тип файла small
      $typeFile["name"] = "small";
      $typeFile["width"] = "90";
      $typeFile["height"] = "40";
      $typeFile["absolute"] = false;
      $manager = new ImageManager();
      $storageFile = $manager->make( storage_path('app/public/'.$photo->miniphoto));
      unlink(storage_path('app/public/'.$photo->miniphoto));
      $resultFile = $storageFile->resize(90,40,function($constraing) {
        $constraing->aspectRatio();
        $constraing->upsize();
      })->save(storage_path('app/public/'.$photo->miniphoto));
      $item["size"] = $resultFile->filesize();
      $item["width"] = $resultFile->width();
      $item["height"] = $resultFile->height();
      $item["filename"] = $photo->miniphoto;
      $item["resize"] = $typeFile;
      $items["small"] = $item;

      $config["files"] = $items;

      $products = Product::whereHas('type_product', function ($query) {
        $query->where('title','Площадочные вибраторы');
      })->where('typeid',$photo->remoteid)->get();
      foreach ($products as $product) {
        $file = new File;
        $file->fileable_id = $product->id;
        $file->fileable_type = Product::class;
        $file->original_name = $photo->photo;
        $file->config = $config;
        $file->type_file_id = 2;
        $file->remoteid = $photo->remoteid;
        $file->save();
      }


      /*$products = Product::whereHas('producer_type_product', function ($query) {
        $query->where('title','Увеличенный ресурс');
      })->where('typeid',$photo->remoteid)->get();
      foreach ($products as $product) {
        $file = new File;
        $file->fileable_id = $product->id;
        $file->fileable_type = "App\Product";
        $file->original_name = $photo->photo;
        $file->config = $config;
        $file->type_file_id = 2;
        $file->remoteid = $photo->remoteid;
        $file->save();
      }*/
    }



    $photos = DB::connection($this->connection)->table('arsenal_photos')->where('tabl','vibrators_figure')->get();
    foreach ($photos as $photo) {
      // тип файла original
      $manager = new ImageManager();
      $storageFile = $manager->make( storage_path('app/public/'.$photo->photo));
      $item["size"] = $storageFile->filesize();
      $item["filename"] = $photo->photo;
      $items["original"] = $item;

      // тип файла main
      $typeFile["name"] = "main";
      $typeFile["width"] = "460";
      $typeFile["height"] = "308";
      $typeFile["absolute"] = false;
      $storageFile = $manager->make( storage_path('app/public/'.$photo->mediumphoto));
      $item["size"] = $storageFile->filesize();
      $item["width"] = $storageFile->width();
      $item["height"] = $storageFile->height();
      $item["filename"] = $photo->mediumphoto;
      $item["resize"] = $typeFile;
      $items["main"] = $item;
      // тип файла medium
      $typeFile["name"] = "medium";
      $typeFile["width"] = "250";
      $typeFile["height"] = "160";
      $typeFile["absolute"] = false;
      $item["resize"] = $typeFile;
      $items["medium"] = $item;

      // тип файла s-medium
      $typeFile["name"] = "s-medium";
      $typeFile["width"] = "180";
      $typeFile["height"] = "100";
      $typeFile["absolute"] = false;
      $item["resize"] = $typeFile;
      $items["s-medium"] = $item;

      // тип файла small
      $typeFile["name"] = "small";
      $typeFile["width"] = "90";
      $typeFile["height"] = "40";
      $typeFile["absolute"] = false;
      $manager = new ImageManager();
      $storageFile = $manager->make( storage_path('app/public/'.$photo->miniphoto));
      unlink(storage_path('app/public/'.$photo->miniphoto));
      $resultFile = $storageFile->resize(90,40,function($constraing) {
        $constraing->aspectRatio();
        $constraing->upsize();
      })->save(storage_path('app/public/'.$photo->miniphoto));
      $item["size"] = $resultFile->filesize();
      $item["width"] = $resultFile->width();
      $item["height"] = $resultFile->height();
      $item["filename"] = $photo->miniphoto;
      $item["resize"] = $typeFile;
      $items["small"] = $item;

      $config["files"] = $items;
      $products = Product::whereHas('type_product', function ($query) {
        $query->where('title','Площадочные вибраторы');
      })->where('figureid',$photo->remoteid)->get();
      foreach ($products as $product) {
        $file = new File;
        $file->fileable_id = $product->id;
        $file->fileable_type = Product::class;
        $file->original_name = $photo->photo;
        $file->config = $config;
        $file->type_file_id = 2;
        $file->remoteid = $photo->remoteid;
        $file->figure = true;
        $file->save();
      }

      $products = Product::whereHas('type_product', function ($query) {
        $query->where('title','Пневматические вибраторы');
      })->where('figureid',$photo->remoteid)->get();
      foreach ($products as $product) {
        $file = new File;
        $file->fileable_id = $product->id;
        $file->fileable_type = Product::class;
        $file->original_name = $photo->photo;
        $file->config = $config;
        $file->type_file_id = 2;
        $file->remoteid = $photo->remoteid;
        $file->figure = true;
        $file->save();
      }


      $products = Product::whereHas('type_product', function ($query) {
        $query->where('title','Системы виброаэрации');
      })->where('figureid',$photo->remoteid)->get();
      foreach ($products as $product) {
        $file = new File;
        $file->fileable_id = $product->id;
        $file->fileable_type = Product::class;
        $file->original_name = $photo->photo;
        $file->config = $config;
        $file->type_file_id = 2;
        $file->remoteid = $photo->remoteid;
        $file->figure = true;
        $file->save();
      }

      $products = Product::whereHas('type_product', function ($query) {
        $query->where('title','Глубинные вибратороы');
      })->where('figureid',$photo->remoteid)->get();
      foreach ($products as $product) {
        $file = new File;
        $file->fileable_id = $product->id;
        $file->fileable_type = Product::class;
        $file->original_name = $photo->photo;
        $file->config = $config;
        $file->type_file_id = 2;
        $file->remoteid = $photo->remoteid;
        $file->figure = true;
        $file->save();
      }

      $products = Product::whereHas('type_product', function ($query) {
        $query->where('title','Гидравлические вибратороы');
      })->where('figureid',$photo->remoteid)->get();
      foreach ($products as $product) {
        $file = new File;
        $file->fileable_id = $product->id;
        $file->fileable_type = Product::class;
        $file->original_name = $photo->photo;
        $file->config = $config;
        $file->type_file_id = 2;
        $file->remoteid = $photo->remoteid;
        $file->save();
      }
    }





    $countGid = 1;
    // гидравлические вибраторы
    $photos = DB::connection($this->connection)->table('arsenal_photos')->where('tabl','concrete_vibrators_types')->get();
    foreach ($photos as $photo) {
      // тип файла original
      $manager = new ImageManager();
      $storageFile = $manager->make( storage_path('app/public/'.$photo->photo));
      $item["size"] = $storageFile->filesize();
      $item["filename"] = $photo->photo;
      $items["original"] = $item;

      // тип файла main
      $typeFile["name"] = "main";
      $typeFile["width"] = "460";
      $typeFile["height"] = "308";
      $typeFile["absolute"] = false;
      $storageFile = $manager->make( storage_path('app/public/'.$photo->mediumphoto));
      $item["size"] = $storageFile->filesize();
      $item["width"] = $storageFile->width();
      $item["height"] = $storageFile->height();
      $item["filename"] = $photo->mediumphoto;
      $item["resize"] = $typeFile;
      $items["main"] = $item;
      // тип файла medium
      $typeFile["name"] = "medium";
      $typeFile["width"] = "250";
      $typeFile["height"] = "160";
      $typeFile["absolute"] = false;
      $item["resize"] = $typeFile;
      $items["medium"] = $item;

      // тип файла s-medium
      $typeFile["name"] = "s-medium";
      $typeFile["width"] = "180";
      $typeFile["height"] = "100";
      $typeFile["absolute"] = false;
      $item["resize"] = $typeFile;
      $items["s-medium"] = $item;

      // тип файла small
      $typeFile["name"] = "small";
      $typeFile["width"] = "90";
      $typeFile["height"] = "40";
      $typeFile["absolute"] = false;
      $manager = new ImageManager();
      $storageFile = $manager->make( storage_path('app/public/'.$photo->miniphoto));
      unlink(storage_path('app/public/'.$photo->miniphoto));
      $resultFile = $storageFile->resize(90,40,function($constraing) {
        $constraing->aspectRatio();
        $constraing->upsize();
      })->save(storage_path('app/public/'.$photo->miniphoto));
      $item["size"] = $resultFile->filesize();
      $item["width"] = $resultFile->width();
      $item["height"] = $resultFile->height();
      $item["filename"] = $photo->miniphoto;
      $item["resize"] = $typeFile;
      $items["small"] = $item;

      $config["files"] = $items;


      if($countGid == 1) {
        $products = Product::whereHas('type_product', function ($query) {
          $query->where('title','Глубинные вибратороы');
        })->where('line_product_id',17)->get();
        foreach ($products as $product) {
          $file = new File;
          $file->fileable_id = $product->id;
          $file->fileable_type = Product::class;
          $file->original_name = $photo->photo;
          $file->config = $config;
          $file->type_file_id = 2;
          $file->remoteid = $photo->remoteid;
          $file->save();
        }
      }
      else {
        $products = Product::whereHas('type_product', function ($query) {
          $query->where('title','Глубинные вибратороы');
        })->where('line_product_id',18)->get();
        foreach ($products as $product) {
          $file = new File;
          $file->fileable_id = $product->id;
          $file->fileable_type = Product::class;
          $file->original_name = $photo->photo;
          $file->config = $config;
          $file->type_file_id = 2;
          $file->remoteid = $photo->remoteid;
          $file->save();
        }
      }
      $countGid++;
    }
  }
}