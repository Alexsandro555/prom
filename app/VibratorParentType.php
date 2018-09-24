<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VibratorParentType extends Model
{
  protected $connection = 'mysql2';

  protected $table = 'vibrators_types_types';
}
