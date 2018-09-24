<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VibratorsFigure extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $table = 'vibrators_figure';

  protected $fillable = ['name','dimc','dimm','dima','dimb','dimg','dimd','dime','dimf','dimh','dimi','diml','dimn','dimxy'];
}
