<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VibratorType extends Model
{
  protected $connection = 'mysql2';

  protected $table = 'vibrators_types';
}
