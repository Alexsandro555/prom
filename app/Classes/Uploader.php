<?php
/**
 * Created by PhpStorm.
 * User: alexsandro
 * Date: 20.02.18
 * Time: 17:07
 */

namespace App\Classes;

use Intervention\Image\ImageManager;

class Uploader
{
  private $manager;

  private $path = 'app/public/';

  public $size;

  public $width;

  public $height;

  public function __construct()
  {
    $this->manager = new ImageManager();
  }

  public function upload($filename, $absolute = false, $width=0, $height=0) {
    $file = $this->manager->make(storage_path($this->path).$filename);
    if($width !== 0 && $height !== 0) {
      $original = $filename;
      $pos = strripos($original,'.');
      $originalNameWithoutExt = substr($original, 0, $pos);
      $extension = substr($original,$pos+1,strlen($original)-1);
      $filename = $this->sanitize($originalNameWithoutExt);
      $allowed_filename = $this->createUniqueFilename($filename, $extension);
      if ($absolute) {
        $uploadiconSuccess = $this->resizeAbsolute($file, $allowed_filename, $width, $height, $this->path);
      } else {
        $uploadiconSuccess = $this->resizeRelative($file, $allowed_filename, $width, $height, $this->path);
      }
      $this->size = $this->size($uploadiconSuccess);
      $this->height = $uploadiconSuccess->height();
      $this->width = $uploadiconSuccess->width();
      return $allowed_filename;
    }
    else {
      $this->size = $this->size($file);
      $this->height = $file->height();
      $this->width = $file->width();
      return $filename;
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


  private function resizeAbsolute( $photo, $filename, $width, $height, $path )
  {
    $image = $this->manager->make( $photo )->resize($width,$height)->save(storage_path($this->path) . $filename );
    return $image;
  }

  private function resizeRelative( $photo, $filename, $width, $height, $path )
  {
    $image = $this->manager->make( $photo );
    $image = $image->resize($width,$height,function($constraing) {
      $constraing->aspectRatio();
      $constraing->upsize();
    })->save(storage_path($this->path) . $filename );
    return $image;
  }

  private function size( $photo )
  {
    $image = $this->manager->make( $photo );
    $size = $image->filesize();
    return $size;
  }

}