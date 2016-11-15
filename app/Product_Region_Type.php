<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Region_Type extends Model
{
    //
    protected $table = 'product_region_types';

    protected $fillable = [
      'product_code', 'region_code', 'type_code', 'year', 'planted_area', 'harvested_area', 'production', 'value', 'yield'
    ];
}
