<?php

namespace App\Http\Controllers;

use App\Product;
use App\Product_Region_Type;
use App\Product_Big_Region_Type;
use App\Product_Country_Type;
use App\Region;
use App\Type;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class ProductRegionTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product_region_type.index');
    }

    public function indexDataTables()
    {
        $data   = Product_Region_Type::join('products', 'product_region_types.product_code', '=', 'products.code')
                        ->join('regions', 'product_region_types.region_code', '=', 'regions.code')
                        ->join('types', 'product_region_types.type_code', '=', 'types.code')
                        ->select([
                            'product_region_types.*',
                            'product_region_types.id as productionId',
                            'products.code as productCode',
                            'products.name as productName',
                            'regions.code as regionCode',
                            'regions.name as regionName',
                            'types.code as typeCode',
                            'types.name as typeName'
                        ]);

        return Datatables::of($data)->make(true);
    }
    #####################################################################################################################

    public function bigRegion()
    {
        return view('product_big_region_type.index');
    }

    public function bigRegionDataTables()
    {
        $data   = Product_Big_Region_Type::join('products', 'product_big_region_types.product_code', '=', 'products.code')
                        ->join('big_regions', 'product_big_region_types.big_region_code', '=', 'big_regions.code')
                        ->join('types', 'product_big_region_types.type_code', '=', 'types.code')
                        ->select([
                            'product_big_region_types.*',
                            'product_big_region_types.id as productionId',
                            'products.code as productCode',
                            'products.name as productName',
                            'big_regions.code as regionCode',
                            'big_regions.name as regionName',
                            'types.code as typeCode',
                            'types.name as typeName'
                        ]);

        return Datatables::of($data)->make(true);
    }
    ######################################################################################################################

    public function country()
    {
        return view('product_country_type.index');
    }

    public function countryDataTables()
    {
        $data   = Product_Country_Type::join('products', 'product_country_types.product_code', '=', 'products.code')
                        ->join('countries', 'product_country_types.country_code', '=', 'countries.code')
                        ->join('types', 'product_country_types.type_code', '=', 'types.code')
                        ->select([
                            'product_country_types.*',
                            'product_country_types.id as productionId',
                            'products.code as productCode',
                            'products.name as productName',
                            'countries.code as regionCode',
                            'countries.name as regionName',
                            'types.code as typeCode',
                            'types.name as typeName'
                        ]);

        return Datatables::of($data)->make(true);
    }
    ######################################################################################################################

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ufs      = Region::all();
        $types    = Type::all();
        $products = Product::all();

        return view('product_region_type.create', compact('ufs', 'types', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs          = $request->except('_token');
        $inputs['yield'] = 0;

        Product_Region_Type::firstOrCreate($inputs);

        return redirect()->route('product-region-type.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($productionId)
    {
        $production = Product_Region_Type::findOrFail($productionId);
        $ufs        = Region::all();
        $types      = Type::all();
        $products   = Product::all();

        return view('product_region_type.edit', compact('production', 'ufs', 'types', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $productionId)
    {
        $production = Product_Region_Type::findOrFail($productionId);

        //dados antes da atualizacao
        $old_planted_area = $production->planted_area;
        $old_harvested_area = $production->harvested_area;
        $old_production = $production->production;
        $old_value = $production->value;
        $old_yield = $production->yield;

        //dados a serem atualizados
        $new_planted_area = $request['planted_area'];
        $new_harvested_area = $request['harvested_area'];
        $new_production = $request['production'];
        $new_value = $request['value'];

        //codigo grande regiao
        $region_code = intval($production->region_code);
        if($region_code>10 && $region_code<18){
            $big_region_code = 1;
        }
        else if($region_code>10 && $region_code<18){
            $big_region_code = 2;
        }
        else if($region_code>20 && $region_code<30){
            $big_region_code = 3;
        }
        else if($region_code>30 && $region_code<36){
            $big_region_code = 4;
        }
        else if($region_code>40 && $region_code<44){
            $big_region_code = 5;
        }
        else if($region_code>49 && $region_code<54){
            $big_region_code = 6    ;
        }

        $big_region_production = Product_Big_Region_Type::where([
                ['big_region_code' , '=', $big_region_code],
                ['type_code', '=', $production->type_code],
                ['product_code', '=', $production->product_code],
                ['year', '=', $production->year]
            ])->first();

        $country_production = Product_Country_Type::where([
                ['country_code' , '=', 1],
                ['type_code', '=', $production->type_code],
                ['product_code', '=', $production->product_code],
                ['year', '=', $production->year]
            ])->first();

        //resultados
        if($new_planted_area>$old_planted_area){
            $result_planted_area = $new_planted_area-$old_planted_area;
            $production->planted_area = $production->planted_area + $result_planted_area;
            $big_region_production->planted_area = $big_region_production->planted_area + $result_planted_area;
            $country_production->planted_area = $country_production->planted_area + $result_planted_area;
        }
        else if($new_planted_area<$old_planted_area){
            $result_planted_area = $old_planted_area-$new_planted_area;
            $production->planted_area = $production->planted_area - $result_planted_area;
            $big_region_production->planted_area = $big_region_production->planted_area - $result_planted_area;
            $country_production->planted_area = $country_production->planted_area - $result_planted_area;
        }
        else
            $result_planted_area = $old_planted_area;

        if($new_harvested_area>$old_harvested_area){
            $result_harvested_area = $new_harvested_area-$old_harvested_area;
            $production->harvested_area = $production->harvested_area + $result_harvested_area;
            $big_region_production->harvested_area = $big_region_production->harvested_area + $result_harvested_area;
            $country_production->harvested_area = $country_production->harvested_area + $result_harvested_area;
        }
        else if($new_harvested_area<$old_harvested_area){
            $result_harvested_area = $old_harvested_area-$new_harvested_area;
            $production->harvested_area = $production->harvested_area - $result_harvested_area;
            $big_region_production->harvested_area = $big_region_production->harvested_area - $result_harvested_area;
            $country_production->harvested_area = $country_production->harvested_area - $result_harvested_area;
        }
        else
            $result_harvested_area = $old_harvested_area;

        if($new_production>$old_production){
            $result_production = $new_production-$old_production;
            $production->production = $production->production + $result_production;
            $big_region_production->production = $big_region_production->production + $result_production;
            $country_production->production = $country_production->production + $result_production;
        }
        else if($new_production<$old_production){
            $result_production = $old_production-$new_production;
            $production->production = $production->production - $result_production;
            $big_region_production->production = $big_region_production->production - $result_production;
            $country_production->production = $country_production->production - $result_production;
        }
        else
            $result_production = $old_production;

        if($new_value>$old_value){
            $result_value = $new_value-$old_value;
            $production->value = $production->value + $result_value;
            $big_region_production->value = $big_region_production->value + $result_value;
            $country_production->value = $country_production->value + $result_value;
        }
        else if($new_value<$old_value){
            $result_value = $old_value-$new_value;
            $production->value = $production->value - $result_value;
            $big_region_production->value = $big_region_production->value - $result_value;
            $country_production->value = $country_production->value - $result_value;
        }
        else
            $result_value = $old_value;

        $new_yield = intval(ceil(($new_production/$new_harvested_area)*1000));

        if($new_yield>$old_yield){
            $result_yield = $new_yield-$old_yield;
            $production->yield = $production->yield + $result_yield;
            $big_region_production->yield = $big_region_production->yield + $result_yield;
            $country_production->yield = $country_production->yield + $result_yield;
        }
        else if($new_yield<$old_yield){
            $result_yield = $old_yield-$new_yield;
            $production->yield = $production->yield - $result_yield;
            $big_region_production->yield = $big_region_production->yield - $result_yield;
            $country_production->yield = $country_production->yield - $result_yield;
        }
        else
            $result_yield = $old_yield;


        $production->save();
        $big_region_production->save();
        $country_production->save();



        return redirect()->route('product-region-type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($productionId)
    {
        if(!\Request::ajax())
            abort(403);


        $production = Product_Region_Type::findOrFail($productionId);

        //codigo grande regiao
        $region_code = intval($production->region_code);
        if($region_code>10 && $region_code<18){
            $big_region_code = 1;
        }
        else if($region_code>10 && $region_code<18){
            $big_region_code = 2;
        }
        else if($region_code>20 && $region_code<30){
            $big_region_code = 3;
        }
        else if($region_code>30 && $region_code<36){
            $big_region_code = 4;
        }
        else if($region_code>40 && $region_code<44){
            $big_region_code = 5;
        }
        else if($region_code>49 && $region_code<54){
            $big_region_code = 6    ;
        }

        $big_region_production = Product_Big_Region_Type::where([
                ['big_region_code' , '=', $big_region_code],
                ['type_code', '=', $production->type_code],
                ['product_code', '=', $production->product_code],
                ['year', '=', $production->year]
            ])->first();

        $country_production = Product_Country_Type::where([
                ['country_code' , '=', 1],
                ['type_code', '=', $production->type_code],
                ['product_code', '=', $production->product_code],
                ['year', '=', $production->year]
            ])->first();

        $big_region_production->planted_area = $big_region_production->planted_area - $production->planted_area;
        $big_region_production->harvested_area = $big_region_production->harvested_area - $production->harvested_area;
        $big_region_production->production = $big_region_production->production - $production->production;
        $big_region_production->value = $big_region_production->value - $production->value;
        $big_region_production->yield = $big_region_production->yield - $production->yield;

        $country_production->planted_area = $country_production->planted_area - $production->planted_area;
        $country_production->harvested_area = $country_production->harvested_area - $production->harvested_area;
        $country_production->production = $country_production->production - $production->production;
        $country_production->value = $country_production->value - $production->value;
        $country_production->yield = $country_production->yield - $production->yield;

        $big_region_production->save();
        $country_production->save();

        $production->delete();

        if($production)
            return response()->json(['status' => 'success']);

        return response()->json(['status' => 'fail']);
    }
}
