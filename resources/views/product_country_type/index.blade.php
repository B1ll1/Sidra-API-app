@extends('layouts.master')

@section('specific_styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
@stop

@section('header_title')
<h1>
    <i class="fa fa-plus fa-fw"></i>Produções Agrícolas do Brasil
</h1>

<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
    <li>Produções Agrícolas</li>
    <li class="active">Brasil</li>
</ol>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="box-title">Produção</div>
                    </div>
                    <div class="box-body">
                        <div class="container-fluid">
                            <table class="table table-striped table-bordered table-responsive" id="productionTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Tipo de Lavoura</th>
                                        <th class="text-center">País</th>
                                        <th class="text-center">Produto</th>
                                        <th class="text-center">Ano</th>
                                        <th class="text-center">Área Plantada</th>
                                        <th class="text-center">Área Colhida</th>
                                        <th class="text-center">Quantidade Produzida</th>
                                        <th class="text-center">Valor</th>
                                        <th class="text-center">Rendimento</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer"></div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('specific_scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
@stop

@section('inline_scripts')
<script>
$(document).ready(function() {
    var table = $('#productionTable');

    table.DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('product-region-type.countryDataTables') !!}',
        columnDefs: [
            {
                'targets': 0,
                'visible': false,
                'orderable': false,
                'searchable': false
            },
        ],
        "order": [[ 2, "asc" ]], // Order by date
        columns: [
            { data: 'id', name: 'product_country_types.id'},
            { data: 'typeName', name: 'types.name' },
            { data: 'regionName', name: 'countries.name' },
            { data: 'productName', name: 'products.name' },
            { data: 'year', name: 'product_country_types.year' },
            { data: 'planted_area', name: 'product_country_types.planted_area' },
            { data: 'harvested_area', name: 'product_country_types.harvested_area' },
            { data: 'production', name: 'product_country_types.production' },
            { data: 'value', name: 'product_country_types.value' },
            { data: 'yield', name: 'product_country_types.yield' },
        ]
    });
});
</script>
@endsection