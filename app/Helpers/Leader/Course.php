<?php
/**
 * Created by PhpStorm.
 * User: alexsandro
 * Date: 21.02.18
 * Time: 13:43
 */

namespace App\Helpers\Leader;

class Course {
  /**
   * @param int $price
   * @param int $current
   * @param bool $flag
   *
   * @return int rub price
   */
  public static function get_price($price,$current,$flag=false) {
    $priceRuNDS = ($current*$price*18)/100+$current*$price;
    if($flag) {
      $result = floor($priceRuNDS);
    }
    else {
      $result = floor($priceRuNDS-($priceRuNDS*7.2419)/100);
    }
    return $result;
  }
}