<?php

namespace App\Http\Controllers;

use App\Product;
use App\Product_Region_Type;
use App\Region;
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
        $regions = Region::all();
        $typeCodeTemp = 81;
        $typeCodePerm= 82;

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
        $regionCode = $request['code'];
        $year = $request['year'];
        $typeCode = 81;
        $array = [];
        $array2 = [];

        $productionsTemp = Product_Region_Type::join('products', 'product_region_types.product_code', '=', 'products.code')
                            ->join('regions', 'product_region_types.region_code', '=', 'regions.code')
                            ->join('types', 'product_region_types.type_code', '=', 'types.code')
                            ->where('regions.code', $regionCode)
                            ->where('product_region_types.year', $year)
                            ->where('product_region_types.type_code', $typeCode)
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
        else {
            foreach ($productionsTemp as $key => $prod) {
               $array[$prod->product_name] = $prod->yield;
            }
        }


        // PERMANENTE
        $productionsPerm = Product_Region_Type::join('products', 'product_region_types.product_code', '=', 'products.code')
                            ->join('regions', 'product_region_types.region_code', '=', 'regions.code')
                            ->join('types', 'product_region_types.type_code', '=', 'types.code')
                            ->where('regions.code', $regionCode)
                            ->where('product_region_types.year', $year)
                            ->where('product_region_types.type_code', 82)
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
        else {
            foreach ($productionsPerm as $key => $prod2) {
               $array2[$prod2->product_name] = $prod2->yield;
            }
        }

        return ['temp' => array_values($array), 'perm' => array_values($array2)];
    }
}
