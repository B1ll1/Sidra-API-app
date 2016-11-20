<?php

namespace App\Http\Controllers;

use App\Product;
use App\Product_Region_Type;
use App\Product_Big_Region_Type;
use App\Product_Country_Type;
use App\Region;
use App\Big_Region;
use App\Country;
use App\Services\ReportService;
use App\Type;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    protected $service;

    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ufs      = Region::all();
        $types    = Type::all();
        $products = Product::all();
        $years = [
            ['id' => '2016', 'name' => '2016'],
            ['id' => '2015', 'name' => '2015'],
            ['id' => '2014', 'name' => '2014'],
            ['id' => '2013', 'name' => '2013'],
            ['id' => '2012', 'name' => '2012'],
            ['id' => '2011', 'name' => '2011'],
            ['id' => '2010', 'name' => '2010'],
            ['id' => '2009', 'name' => '2009'],
            ['id' => '2008', 'name' => '2008'],
            ['id' => '2007', 'name' => '2007'],
            ['id' => '2006', 'name' => '2006'],
            ['id' => '2005', 'name' => '2005'],
            ['id' => '2004', 'name' => '2004'],
            ['id' => '2003', 'name' => '2003'],
            ['id' => '2002', 'name' => '2002'],
            ['id' => '2001', 'name' => '2001'],
            ['id' => '2000', 'name' => '2000'],
        ];

        return view('reports.index', compact('ufs', 'types', 'products', 'years'));
    }

    public function generateReport(Request $request)
    {
        $data        = $this->service->generate($request->except('_token'));
        $productions = $data['prodByYear'];
        $products    = $data['productNames'];
        $regions     = $data['regionNames'];
        $dates       = $data['dates'];

        return view('reports.generated', compact('productions', 'dates', 'products', 'regions'));
    }

    public function productionForRegionChart()
    {
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        $regions      = Region::all();
        $typeCodeTemp = 81;
        $typeCodePerm = 82;

        $productionsTemp = Product_Region_Type::join('products', 'product_region_types.product_code', '=', 'products.code')
                            ->join('regions', 'product_region_types.region_code', '=', 'regions.code')
                            ->join('types', 'product_region_types.type_code', '=', 'types.code')
                            ->where('product_region_types.type_code', $typeCodeTemp)
                            ->select([
                                'product_region_types.*',
                                'products.name as product_name',
                                'regions.name as region_name',
                            ])
                            ->get();

        $categories = array_unique($productionsTemp->pluck('product_name')->all());

        // PERMANENTE
        $productionsPerm = Product_Region_Type::join('products', 'product_region_types.product_code', '=', 'products.code')
                            ->join('regions', 'product_region_types.region_code', '=', 'regions.code')
                            ->join('types', 'product_region_types.type_code', '=', 'types.code')
                            ->where('product_region_types.type_code', $typeCodePerm)
                            ->select([
                                'product_region_types.*',
                                'products.name as product_name',
                                'regions.name as region_name',
                            ])
                            ->get();

        $categoriesPerm = array_unique($productionsPerm->pluck('product_name')->all());

        return view('reports.production_per_region', compact('regions', 'categories', 'categoriesPerm'));
    }

    public function productionForRegionChartData(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        $regionCode   = $request['code'];
        $year         = $request['year'];
        $typeCodeTemp = 81;
        $typeCodePerm = 82;
        $array        = [];
        $array2       = [];
        $array3       = [];
        $array4       = [];
        $array5       = [];
        $array6       = [];

        $productionsTemp = Product_Region_Type::join('products', 'product_region_types.product_code', '=', 'products.code')
                            ->join('regions', 'product_region_types.region_code', '=', 'regions.code')
                            ->join('types', 'product_region_types.type_code', '=', 'types.code')
                            ->where('regions.code', $regionCode)
                            ->where('product_region_types.year', $year)
                            ->where('product_region_types.type_code', $typeCodeTemp)
                            ->select([
                                'product_region_types.*',
                                'products.name as product_name',
                                'regions.name as region_name',
                            ])
                            ->get();

        if($request['attr'] == 0) {
            foreach ($productionsTemp as $key => $prod) {
               $array[$prod->product_name] = $prod->production;
            }
        }
        else if($request['attr'] == 1) {
            foreach ($productionsTemp as $key => $prod) {
               $array[$prod->product_name] = $prod->yield;
            }
        }
        else {
            foreach ($productionsTemp as $key => $prod) {
               $array3[$prod->product_name] = $prod->planted_area;
               $array4[$prod->product_name] = $prod->harvested_area;
            }
        }


        // PERMANENTE
        $productionsPerm = Product_Region_Type::join('products', 'product_region_types.product_code', '=', 'products.code')
                            ->join('regions', 'product_region_types.region_code', '=', 'regions.code')
                            ->join('types', 'product_region_types.type_code', '=', 'types.code')
                            ->where('regions.code', $regionCode)
                            ->where('product_region_types.year', $year)
                            ->where('product_region_types.type_code', $typeCodePerm)
                            ->select([
                                'product_region_types.*',
                                'products.name as product_name',
                                'regions.name as region_name',
                            ])
                            ->get();
        if($request['attr'] == 0) {
            foreach ($productionsPerm as $key => $prod2) {
               $array2[$prod2->product_name] = $prod2->production;
            }
        }
        else if($request['attr'] == 1) {
            foreach ($productionsPerm as $key => $prod2) {
               $array2[$prod2->product_name] = $prod2->yield;
            }
        }
        else {
            foreach ($productionsPerm as $key => $prod2) {
               $array5[$prod2->product_name] = $prod2->planted_area;
               $array6[$prod2->product_name] = $prod2->harvested_area;
            }
        }

        return [
            'temp'      => array_values($array),
            'perm'      => array_values($array2),
            'planted-t'   => array_values($array3),
            'harvested-t' => array_values($array4),
            'planted-p'   => array_values($array5),
            'harvested-p' => array_values($array6),
        ];
    }

    ############################################### GRANDE REGIÃO ################################################
    public function productionForBigRegionChart()
    {
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        $regions      = Big_Region::all();
        $typeCodeTemp = 81;
        $typeCodePerm = 82;

        $productionsTemp = Product_Big_Region_Type::join('products', 'product_big_region_types.product_code', '=', 'products.code')
                            ->join('big_regions', 'product_big_region_types.big_region_code', '=', 'big_regions.code')
                            ->join('types', 'product_big_region_types.type_code', '=', 'types.code')
                            ->where('product_big_region_types.type_code', $typeCodeTemp)
                            ->select([
                                'product_big_region_types.*',
                                'products.name as product_name',
                                'big_regions.name as region_name',
                            ])
                            ->get();

        $categories = array_unique($productionsTemp->pluck('product_name')->all());

        // PERMANENTE
        $productionsPerm = Product_Big_Region_Type::join('products', 'product_big_region_types.product_code', '=', 'products.code')
                            ->join('big_regions', 'product_big_region_types.big_region_code', '=', 'big_regions.code')
                            ->join('types', 'product_big_region_types.type_code', '=', 'types.code')
                            ->where('product_big_region_types.type_code', $typeCodePerm)
                            ->select([
                                'product_big_region_types.*',
                                'products.name as product_name',
                                'big_regions.name as region_name',
                            ])
                            ->get();

        $categoriesPerm = array_unique($productionsPerm->pluck('product_name')->all());

        return view('reports.production_per_big_region', compact('regions', 'categories', 'categoriesPerm'));
    }

    public function productionForBigRegionChartData(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        $regionCode   = $request['code'];
        $year         = $request['year'];
        $typeCodeTemp = 81;
        $typeCodePerm = 82;
        $array        = [];
        $array2       = [];
        $array3       = [];
        $array4       = [];
        $array5       = [];
        $array6       = [];

        $productionsTemp = Product_Big_Region_Type::join('products', 'product_big_region_types.product_code', '=', 'products.code')
                            ->join('big_regions', 'product_big_region_types.big_region_code', '=', 'big_regions.code')
                            ->join('types', 'product_big_region_types.type_code', '=', 'types.code')
                            ->where('big_regions.code', $regionCode)
                            ->where('product_big_region_types.year', $year)
                            ->where('product_big_region_types.type_code', $typeCodeTemp)
                            ->select([
                                'product_big_region_types.*',
                                'products.name as product_name',
                                'big_regions.name as region_name',
                            ])
                            ->get();

        if($request['attr'] == 0) {
            foreach ($productionsTemp as $key => $prod) {
               $array[$prod->product_name] = $prod->production;
            }
        }
        else if($request['attr'] == 1) {
            foreach ($productionsTemp as $key => $prod) {
               $array[$prod->product_name] = $prod->yield;
            }
        }
        else {
            foreach ($productionsTemp as $key => $prod) {
               $array3[$prod->product_name] = $prod->planted_area;
               $array4[$prod->product_name] = $prod->harvested_area;
            }
        }


        // PERMANENTE
        $productionsPerm = Product_Big_Region_Type::join('products', 'product_big_region_types.product_code', '=', 'products.code')
                            ->join('big_regions', 'product_big_region_types.big_region_code', '=', 'big_regions.code')
                            ->join('types', 'product_big_region_types.type_code', '=', 'types.code')
                            ->where('big_regions.code', $regionCode)
                            ->where('product_big_region_types.year', $year)
                            ->where('product_big_region_types.type_code', $typeCodePerm)
                            ->select([
                                'product_big_region_types.*',
                                'products.name as product_name',
                                'big_regions.name as region_name',
                            ])
                            ->get();
        if($request['attr'] == 0) {
            foreach ($productionsPerm as $key => $prod2) {
               $array2[$prod2->product_name] = $prod2->production;
            }
        }
        else if($request['attr'] == 1) {
            foreach ($productionsPerm as $key => $prod2) {
               $array2[$prod2->product_name] = $prod2->yield;
            }
        }
        else {
            foreach ($productionsPerm as $key => $prod2) {
               $array5[$prod2->product_name] = $prod2->planted_area;
               $array6[$prod2->product_name] = $prod2->harvested_area;
            }
        }

        return [
            'temp'      => array_values($array),
            'perm'      => array_values($array2),
            'planted-t'   => array_values($array3),
            'harvested-t' => array_values($array4),
            'planted-p'   => array_values($array5),
            'harvested-p' => array_values($array6),
        ];
    }

    ############################################### PAÍS ################################################
    public function productionForCountryChart()
    {
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        $regions      = Country::all();
        $typeCodeTemp = 81;
        $typeCodePerm = 82;

        $productionsTemp = Product_Country_Type::join('products', 'product_country_types.product_code', '=', 'products.code')
                            ->join('countries', 'product_country_types.country_code', '=', 'countries.code')
                            ->join('types', 'product_country_types.type_code', '=', 'types.code')
                            ->where('product_country_types.type_code', $typeCodeTemp)
                            ->select([
                                'product_country_types.*',
                                'products.name as product_name',
                                'countries.name as region_name',
                            ])
                            ->get();

        $categories = array_unique($productionsTemp->pluck('product_name')->all());

        // PERMANENTE
        $productionsPerm = Product_Country_Type::join('products', 'product_country_types.product_code', '=', 'products.code')
                            ->join('countries', 'product_country_types.country_code', '=', 'countries.code')
                            ->join('types', 'product_country_types.type_code', '=', 'types.code')
                            ->where('product_country_types.type_code', $typeCodePerm)
                            ->select([
                                'product_country_types.*',
                                'products.name as product_name',
                                'countries.name as region_name',
                            ])
                            ->get();

        $categoriesPerm = array_unique($productionsPerm->pluck('product_name')->all());

        return view('reports.production_per_country', compact('regions', 'categories', 'categoriesPerm'));
    }

    public function productionForCountryChartData(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        $regionCode   = $request['code'];
        $year         = $request['year'];
        $typeCodeTemp = 81;
        $typeCodePerm = 82;
        $array        = [];
        $array2       = [];
        $array3       = [];
        $array4       = [];
        $array5       = [];
        $array6       = [];

        $productionsTemp = Product_Country_Type::join('products', 'product_country_types.product_code', '=', 'products.code')
                            ->join('countries', 'product_country_types.country_code', '=', 'countries.code')
                            ->join('types', 'product_country_types.type_code', '=', 'types.code')
                            ->where('countries.code', $regionCode)
                            ->where('product_country_types.year', $year)
                            ->where('product_country_types.type_code', $typeCodeTemp)
                            ->select([
                                'product_country_types.*',
                                'products.name as product_name',
                                'countries.name as region_name',
                            ])
                            ->get();

        if($request['attr'] == 0) {
            foreach ($productionsTemp as $key => $prod) {
               $array[$prod->product_name] = $prod->production;
            }
        }
        else if($request['attr'] == 1) {
            foreach ($productionsTemp as $key => $prod) {
               $array[$prod->product_name] = $prod->yield;
            }
        }
        else {
            foreach ($productionsTemp as $key => $prod) {
               $array3[$prod->product_name] = $prod->planted_area;
               $array4[$prod->product_name] = $prod->harvested_area;
            }
        }


        // PERMANENTE
        $productionsPerm = Product_Country_Type::join('products', 'product_country_types.product_code', '=', 'products.code')
                            ->join('countries', 'product_country_types.country_code', '=', 'countries.code')
                            ->join('types', 'product_country_types.type_code', '=', 'types.code')
                            ->where('countries.code', $regionCode)
                            ->where('product_country_types.year', $year)
                            ->where('product_country_types.type_code', $typeCodePerm)
                            ->select([
                                'product_country_types.*',
                                'products.name as product_name',
                                'countries.name as region_name',
                            ])
                            ->get();

        if($request['attr'] == 0) {
            foreach ($productionsPerm as $key => $prod2) {
               $array2[$prod2->product_name] = $prod2->production;
            }
        }
        else if($request['attr'] == 1) {
            foreach ($productionsPerm as $key => $prod2) {
               $array2[$prod2->product_name] = $prod2->yield;
            }
        }
        else {
            foreach ($productionsPerm as $key => $prod2) {
               $array5[$prod2->product_name] = $prod2->planted_area;
               $array6[$prod2->product_name] = $prod2->harvested_area;
            }
        }

        return [
            'temp'        => array_values($array),
            'perm'        => array_values($array2),
            'planted-t'   => array_values($array3),
            'harvested-t' => array_values($array4),
            'planted-p'   => array_values($array5),
            'harvested-p' => array_values($array6),
        ];
    }
}
