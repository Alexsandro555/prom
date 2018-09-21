<?php
/**
 * Created by PhpStorm.
 * User: alexsandro
 * Date: 26.02.18
 * Time: 9:33
 */

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use App\VibratorsFigure;

class VibratorsFigureTable
{
  public function make() {
    $vibratorsFigures = DB::connection('mysql2')->table('vibrators_figure')->get();
    foreach ($vibratorsFigures as $vibratorsFigure) {
      $vF = new VibratorsFigure;
      $vF->name = $vibratorsFigure->name;
      $vF->dimc = $vibratorsFigure->dimc;
      $vF->dimm = $vibratorsFigure->dimm;
      $vF->dima = $vibratorsFigure->dima;
      $vF->dimb = $vibratorsFigure->dimb;
      $vF->dimg = $vibratorsFigure->dimg;
      $vF->dimd = $vibratorsFigure->dimd;
      $vF->dime = $vibratorsFigure->dime;
      $vF->dimf = $vibratorsFigure->dimf;
      $vF->dimh = $vibratorsFigure->dimh;
      $vF->dimi = $vibratorsFigure->dimi;
      $vF->diml = $vibratorsFigure->diml;
      $vF->dimn = $vibratorsFigure->dimn;
      $vF->dimxy = $vibratorsFigure->dimxy;
      $vF->save();
    }
  }
}