<?php

namespace App\Http\Controllers;

use App\Product;
use App\Product_Region_Type;
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
                            'products.code as productCode',
                            'products.name as productName',
                            'regions.code as regionCode',
                            'regions.name as regionName',
                            'types.code as typeCode',
                            'types.name as typeName'
                        ]);
        // dd($data->get());
        return Datatables::of($data)->make(true);
    }

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
        Product_Region_Type::create($request->except('_token'));

        return redirect()->route('product-region-type.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}