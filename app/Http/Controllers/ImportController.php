<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\Product;
use App\Type;
use App\Region;
use App\Product_Region_Type;

class ImportController extends Controller
{

    public function Import(Request $request)
    {
        $file  = Input::file('import_file');
        $products = [];
        $regions = [];
        $product_region_type =[];
        $products_region =[];
        // $counter=0;
        set_time_limit(0);
            if(isset($file)){
                $path = $file->getRealPath();
                $data =  Excel::load($path, function($reader) {
                    })->get();
                        if(!empty($data) && $data->count()){
                            foreach($data as $key => $value){
                                //usado para popular produtos e regioes
                                // array_push($products,['code' => $value->d1c, 'name' => $value->d1n]);
                                // array_push($regions,['code' => $value->d2c, 'name' => $value->d2n]);
                                //fim--

                                //usado para popular tabela relacionamento
                                if(sizeof($products)<4){
                                    array_push($products,intval($value->v));
                              }
                                else{
                                    $product_region_type = ['product_code' => intval($value->d1c), 'region_code' => intval($value->d2c), 'type_code' => 81, 'year' => intval($value->d3c), 'planted_area' => $products[0], 'harvested_area' => $products[1], 'production' => $products[2], 'value' => $products[3], 'yield' => intval($value->v)];

                                    Product_Region_Type::insert($product_region_type);
                                    $products=[];
                                }

                                //fim
                            }

                            dd('foi');
                            // $products = $this->arrayUnique($products);
                            // $regions = $this->arrayUnique($regions);
                           // Product::insert($products);
                           // Region::insert($regions);
                        }
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
