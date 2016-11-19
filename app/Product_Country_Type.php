<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Country_Type extends Model
{
    //
    protected $table = 'product_country_types';

    protected $fillable = [
      'product_code', 'country_code', 'type_code', 'year', 'planted_area', 'harvested_area', 'production', 'value', 'yield'
    ];

}
