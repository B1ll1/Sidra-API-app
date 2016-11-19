<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Big_Region_Type extends Model
{
    //
    protected $table = 'product_big_region_types';

    protected $fillable = [
      'product_code', 'big_region_code', 'type_code', 'year', 'planted_area', 'harvested_area', 'production', 'value', 'yield'
    ];
}
