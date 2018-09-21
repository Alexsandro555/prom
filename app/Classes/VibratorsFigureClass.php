<?php
/**
 * Created by PhpStorm.
 * User: alexsandro
 * Date: 19.02.18
 * Time: 16:35
 */

namespace App\Classes;

use App\Product;
use Leader\UploadFile\Models\File;
use App\VibratorsFigure;
use Illuminate\Support\Facades\Storage;

class VibratorsFigureClass
{
  private $path = 'app/public/';

  public function make() {

    putenv('GDFONTPATH=' . $_SERVER["DOCUMENT_ROOT"].'/fonts/msttcorefonts/');
    //putenv('GDFONTPATH=' . realpath('/usr/share/fonts/truetype/msttcorefonts/'));

    $products = Product::with('type_product')->whereHas('type_product', function ($query) {
      $query->where('title','Площадочные вибраторы');
    })->get();
    foreach ($products as $product) {
      foreach ($product->files as $file) {
        if($file->figure && !$file->processed) {
          $filename = '';
          $originalFile = '';
          foreach ($file->config as $key=>$configFiles) {
            foreach ($configFiles as $key=>$configFile) {
              if($key == 'medium') {
                $filename = $configFile["filename"];
              }
              if($key == 'original') {
                $originalFile  = $configFile['filename'];
              }
            }
          }
          if($filename == "") break;

          $vibratorsFigure = VibratorsFigure::find($file->remoteid);
          $imageFile = storage_path($this->path.$filename);
          $path_parts = pathinfo($imageFile);
          $ext = $path_parts["extension"];
          switch ($ext)
          {
            case "jpg":
              $img = imagecreatefromjpeg($imageFile);
              break;
            case "gif":
              $img = imagecreatefromgif($imageFile);
              break;
            case "png":
              $img = imagecreatefrompng($imageFile);
              break;
            default:
              break;
          }
          if ($img)
          {
            $orig_width = imagesx($img);
            $orig_height = imagesy($img);
            $index = imagecolorresolve ( $img, 227,227,227 );
            imagecolorset($img, $index, 255, 255, 255);
            $index = imagecolorresolve ( $img, 229,229,229 );
            imagecolorset($img, $index, 255, 255, 255);

            $color = imagecolorallocatealpha($img, 0, 0, 0, 0);
            $color0=imagecolorallocatealpha($img, 255, 0, 0, 0);
            $color1=imagecolorallocatealpha($img, 0, 0, 255, 0);
            //putenv('GDFONTPATH=' . realpath('/Library/fonts/'));

            // Обработка массива атрибутов
            $arrayF=$vibratorsFigure->toArray();
            foreach ($arrayF as $key=>$value)
            {
              if (preg_match("#dim#i",$key))
              {
                if (trim($vibratorsFigure->{$key})!='')
                {
                  list($x,$y,$angle)=explode("/",$vibratorsFigure->{$key});
                  if ($product->typeid==19) {$x=$x/100*$orig_width;$y=$y/100*$orig_height;}
                  if (!preg_match("#/#i",$product->{$key}))
                  {
                    $box = imagettftext($img, 10, $angle,$x, $y,$color, "arial.ttf", iconv("koi8-r","UTF-8",$product->{$key}));
                  }
                  else
                  {
                    $arrofdim=explode("/",$product->{$key});
                    for ($i=0;$i<count($arrofdim);$i++)
                    {
                      $col=$i%2;
                      list($lowlx,$lowly,$lowrx,$lowry,$toplx,$toply,$toprx,$topry) = imagettftext($img, 10, $angle,$x, $y,${'color'.$col}, "arial.ttf", iconv("koi8-r","UTF-8",$arrofdim[$i]));
                      if ($angle==0) {$x=$lowrx+2;}
                      if ($angle==90) {$y=$toply-7;}
                      if ($angle==30) {$y=$toply+9;$x=$lowrx+3;}
                      if ($angle==35) {$y=$toply+9;$x=$lowrx+3;}
                      if ($i+1!=count($arrofdim)) {
                        imagettftext($img, 10, $angle,$x, $y,$color, "arial.ttf", iconv("koi8-r","UTF-8","/"));
                        if ($angle==0) {$x=$x+5;}
                        if ($angle==90) {$y=$y-5;}
                        if ($angle==30) {$y=$toply+6;$x=$lowrx+8;}
                        if ($angle==35) {$y=$toply+4;$x=$lowrx+7;}
                      }
                    }
                  }
                }
              }
            }

            $imageFile = storage_path($this->path.$originalFile);
            $path_parts = pathinfo($imageFile);
            $ext = $path_parts["extension"];
            $imageFileWithoutExt = $path_parts["filename"];
            $filename = $this->sanitize($imageFileWithoutExt);
            $allowed_filename = $this->createUniqueFilename($filename, $ext);

            /*switch ($ext)
            {
              case "jpg":
                header("Content-type: " .image_type_to_mime_type(IMAGETYPE_JPEG));
                imagejpeg($img);
                break;
              case "gif":
                header("Content-type: " .image_type_to_mime_type(IMAGETYPE_GIF));
                imagegif($img);
                break;
              case "png":
                header("Content-type: " .image_type_to_mime_type(IMAGETYPE_PNG));
                imagepng($img);
                break;
              default:
                echo "îÅÉÚ×ÅÓÔÎÏÅ ÒÁÓÛÉÒÅÎÉÅ ÆÁÊÌÁ";
                exit();
            }*/


            switch ($ext)
            {
              case "jpg":
                imagejpeg($img,storage_path($this->path).$allowed_filename);
                break;
              case "gif":
                imagegif($img, storage_path($this->path).$allowed_filename);
                break;
              case "png":
                imagepng($img, storage_path($this->path).$allowed_filename);
                break;
              default:
                break;
            }

            //Начало построения структуры коллекции
            $width = imagesx($img);
            $height = imagesy($img);
            $size = filesize(storage_path($this->path).$allowed_filename);
            $fileItem = collect();
            $fileItem->put('filename',$allowed_filename);
            $fileItem->put('size',$size);
            $fileItem->put('width',$width);
            $fileItem->put('height',$height);

            $resize = [];
            foreach ($file->config as $confFiles) {
              foreach ($confFiles as $key=>$confFile) {
                if($key == 'medium') {
                  $resize = $confFile["resize"];
                }
              }
            }
            $fileItem->put('resize',$resize);
            $arrFile = $file->config->get('files');
            $arrFile["medium"] = $fileItem;
            $fileCollect = collect();
            $fileCollect->put('files',$arrFile);
            // Конец построения структуры коллекции
            $file->config = $fileCollect;
            $file->processed = true;
            $file->save();
          }
        }
      }
    }



    // Пневматические вибраторы
    $products = Product::with('type_product')->whereHas('type_product', function ($query) {
      $query->where('title','Пневматические вибраторы');
    })->get();
    foreach ($products as $product) {
      foreach ($product->files as $file) {
        if($file->figure && !$file->processed) {
          $filename = '';
          $originalFile = '';
          foreach ($file->config as $key=>$configFiles) {
            foreach ($configFiles as $key=>$configFile) {
              if($key == 'medium') {
                $filename = $configFile["filename"];
              }
              if($key == 'original') {
                $originalFile  = $configFile['filename'];
              }
            }
          }
          if($filename == "") break;

          $vibratorsFigure = VibratorsFigure::find($file->remoteid);
          $imageFile = storage_path($this->path.$filename);
          $path_parts = pathinfo($imageFile);
          $ext = $path_parts["extension"];
          switch ($ext)
          {
            case "jpg":
              $img = imagecreatefromjpeg($imageFile);
              break;
            case "gif":
              $img = imagecreatefromgif($imageFile);
              break;
            case "png":
              $img = imagecreatefrompng($imageFile);
              break;
            default:
              break;
          }

          $index = imagecolorresolve ( $img, 227,227,227 );
          imagecolorset($img, $index, 255, 255, 255);
          $index = imagecolorresolve ( $img, 228,228,228 );
          imagecolorset($img, $index, 255, 255, 255);
          $index = imagecolorresolve ( $img, 229,229,229 );
          imagecolorset($img, $index, 255, 255, 255);

          $color = imagecolorallocatealpha($img, 0, 0, 0, 0);
          $color0=imagecolorallocatealpha($img, 255, 0, 0, 0);
          $color1=imagecolorallocatealpha($img, 0, 0, 255, 0);

          $id = $product->id;

          // Обработка массива атрибутов
          $arrayF=$vibratorsFigure->toArray();
          foreach ($arrayF as $key=>$value)
          {
            if (preg_match("#dim#i",$key))
            {
              if (trim($vibratorsFigure->{$key})!='')
              {
                $arrF=explode("|",$vibratorsFigure->{$key});
                for ($i=0;$i<count($arrF);$i++)
                {
                  list($x,$y,$angle)=explode("/",$arrF[$i]);
                  if ($id>=30) {$x=round(imagesx($img)/100*$x);$y=round(imagesy($img)/100*$y);}
                  $product->{$key}=str_replace("&diam;","&#216;",$product->{$key});
                  $box = imagettftext($img, 10, $angle,$x, $y,$color, "arial.ttf", iconv("koi8-r","UTF-8",$product->{$key}));
                }
              }
            }
          }

          $imageFile = storage_path($this->path.$originalFile);
          $path_parts = pathinfo($imageFile);
          $ext = $path_parts["extension"];
          $imageFileWithoutExt = $path_parts["filename"];
          $filename = $this->sanitize($imageFileWithoutExt);
          $allowed_filename = $this->createUniqueFilename($filename, $ext);

          switch ($ext)
          {
            case "jpg":
              imagejpeg($img,storage_path($this->path).$allowed_filename);
              break;
            case "gif":
              imagegif($img, storage_path($this->path).$allowed_filename);
              break;
            case "png":
              imagepng($img, storage_path($this->path).$allowed_filename);
              break;
            default:
              break;
          }

          //Начало построения структуры коллекции
          $width = imagesx($img);
          $height = imagesy($img);
          $size = filesize(storage_path($this->path).$allowed_filename);
          $fileItem = collect();
          $fileItem->put('filename',$allowed_filename);
          $fileItem->put('size',$size);
          $fileItem->put('width',$width);
          $fileItem->put('height',$height);

          $resize = [];
          foreach ($file->config as $confFiles) {
            foreach ($confFiles as $key=>$confFile) {
              if($key == 'medium') {
                $resize = $confFile["resize"];
              }
            }
          }
          $fileItem->put('resize',$resize);
          $arrFile = $file->config->get('files');
          $arrFile["medium"] = $fileItem;
          $fileCollect = collect();
          $fileCollect->put('files',$arrFile);
          // Конец построения структуры коллекции
          $file->config = $fileCollect;
          $file->processed = true;
          $file->save();
        }
      }
    }

  }

  private function sanitize($string, $force_lowercase = true, $anal = false)
  {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
      "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
      "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

    return ($force_lowercase) ?
      (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
      $clean;
  }

  private function createUniqueFilename($filename, $extension)
  {
    $full_size_dir = storage_path($this->path);
    $full_image_path = $full_size_dir . $filename . '.' . $extension;

    if ( file_exists( $full_image_path ) )
    {
      // Generate token for image
      $imageToken = substr(sha1(mt_rand()), 0, 5);
      return $filename . '-' . $imageToken . '.' . $extension;
    }
    return $filename . '.' . $extension;
  }

}