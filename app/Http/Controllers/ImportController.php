<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\Product;
use App\Type;
use App\Region;
use App\Big_Region;
use App\Product_Region_Type;
use App\Product_Big_Region_Type;
use App\Product_Country_Type;


class ImportController extends Controller
{

    public function Import(Request $request)
    {
        $files  = Input::file('import_file');
        $products = [];
        $regions = [];
        $big_regions = [];
        $countries = [];
        $product_region_type = [];
        $product_big_region_type = [];
        $product_country_type = [];
        $products_region = [];
        // $counter=0;
        set_time_limit(0);
            if(isset($files)){
                foreach($files as $file){
                $path = $file->getRealPath();
                $data =  Excel::load($path, function($reader) {
                    })->get();
                        if(!empty($data) && $data->count()){
                            foreach($data as $key => $value){
                                //usado para popular produtos e regioes
                                // array_push($products,['code' => $value->d1c, 'name' => $value->d1n]);
                                // array_push($regions,['code' => $value->d2c, 'name' => $value->d2n]);
                                // array_push($big_regions,['code' => $value->d2c, 'name' => $value->d2n]);
                                //fim--

                                //usado para popular tabela relacionamento
                                if(sizeof($products)<4){
                                    array_push($products,intval($value->v));
                                }
                                else{
                                    // product region type
                                    // $product_region_type = ['product_code' => intval($value->d1c), 'region_code' => intval($value->d2c), 'type_code' => 81, 'year' => intval($value->d3c), 'planted_area' => $products[0], 'harvested_area' => $products[1], 'production' => $products[2], 'yield' => $products[3], 'value' => intval($value->v)];
                                    // Product_Region_Type::insert($product_region_type);

                                    // product big region type
                                    // $product_big_region_type = ['product_code' => intval($value->d1c), 'big_region_code' => intval($value->d2c), 'type_code' => 81, 'year' => intval($value->d3c), 'planted_area' => $products[0], 'harvested_area' => $products[1], 'production' => $products[2], 'yield' => $products[3], 'value' => intval($value->v)];
                                    // Product_Big_Region_Type::insert($product_big_region_type);

                                    // product country type
                                    $product_country_type = ['product_code' => intval($value->d1c), 'country_code' => intval($value->d2c), 'type_code' => 82, 'year' => intval($value->d3c), 'planted_area' => $products[0], 'harvested_area' => $products[1], 'production' => $products[2], 'yield' => $products[3], 'value' => intval($value->v)];
                                    Product_Country_Type::insert($product_country_type);

                                    // zerar array de produtos
                                    $products = [];
                                }

                                //fim
                            }
                            // $products = $this->arrayUnique($products);
                            // $big_regions = $this->arrayUnique($big_regions);
                            // dd($regions);
                           // Product::insert($products);
                           // Region::insert($regions);
                           // Big_Region::insert($big_regions);
                        }
                    }
                    dd('foi');

            }


             return redirect()->route('index');

    }

    function arrayUnique($myArray){
        if(!is_array($myArray))
            return $myArray;

        foreach ($myArray as &$myvalue){
            $myvalue=serialize($myvalue);
        }

        $myArray=array_unique($myArray);

        foreach ($myArray as &$myvalue){
            $myvalue=unserialize($myvalue);
        }

        return $myArray;

    }
}
