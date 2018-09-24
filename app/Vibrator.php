<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vibrator extends Model
{
  protected $connection = 'mysql2';

  protected $table = 'vibrators';
}
