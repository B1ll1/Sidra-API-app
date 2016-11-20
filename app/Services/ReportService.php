<?php

namespace App\Services;

use App\Product_Region_Type;

class ReportService
{
    public function generate($data)
    {
        $date_start = $data['date_start'];
        $date_end = $data['date_end'];

        $productions = Product_Region_Type::join('products', 'product_region_types.product_code', '=', 'products.code')
                            ->join('regions', 'product_region_types.region_code', '=', 'regions.code')
                            ->join('types', 'product_region_types.type_code', '=', 'types.code')
                            ->whereIn('products.code', $data['products'])
                            ->whereIn('regions.code', $data['regions'])
                            ->where('product_region_types.year', '>=', $date_start)
                            ->where('product_region_types.year', '<=', $date_end)
                            ->select([
                                'product_region_types.*',
                                'products.name as product_name',
                                'regions.name as region_name',
                            ])
                            ->get();

        foreach ($productions as $key => $production) {
            $prodByYear[$production->region_name][$production->year][$production->product_name] = $production->planted_area;
        }

        // dd($prodByYear);

        $products_names = array_unique($productions->pluck('product_name')->all());
        $regions_names  = array_unique($productions->pluck('region_name')->all());
        $dates          = [$date_start, $date_end];

        return ['prodByYear' => $prodByYear, 'dates' => $dates, 'productNames' => $products_names, 'regionNames' => $regions_names];
    }
}
