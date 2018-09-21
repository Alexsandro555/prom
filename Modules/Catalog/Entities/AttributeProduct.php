<?php
namespace Modules\Catalog\Entities;
use Illuminate\Database\Eloquent\Model;

class AttributeProduct extends Model
{
  protected $table = 'attribute_product';

  protected $fillable = [
    'product_id',
    'attribute_id',
    'value',
    'group_id'
  ];

  public function group() {
    return $this->belongsTo('App\Group');
  }
}