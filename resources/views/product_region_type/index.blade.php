@extends('layouts.master')

@section('specific_styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
@stop

@section('header_title')
<h1>
    <i class="fa fa-plus fa-fw"></i>Produções Agrícolas por Estados
</h1>

<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
    <li class="active">Produções Agrícolas</li>
</ol>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        {{-- <div class="box-title">Produção</div> --}}
                    </div>
                    <div class="box-body">
                        <div class="container-fluid">
                            <table class="table table-striped table-responsive" id="productionTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Tipo de Lavoura</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Produto</th>
                                        <th class="text-center">Ano</th>
                                        <th class="text-center">Área Plantada</th>
                                        <th class="text-center">Área Colhida</th>
                                        <th class="text-center">Quantidade Produzida</th>
                                        <th class="text-center">Valor</th>
                                        <th class="text-center">Rendimento</th>
                                        <th class="text-center"></th>
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
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"></script> --}}
@stop

@section('inline_scripts')
<script>
$(document).ready(function() {
    var table = $('#productionTable');

    table.DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json',
        },
        processing: true,
        serverSide: true,
        ajax: '{!! route('product-region-type.indexDataTables') !!}',
        lengthMenu: [
            [ 30, 50, 100, -1 ],
            [ '30 linhas', '50 linhas', '100 linhas', 'Todos' ]
        ],
        dom: 'Bfrtip',
        buttons: [
            'pageLength', 'csv', 'excel', 'pdf', 'print'
        ],
        columnDefs: [
            {
                'targets': 0,
                'visible': false
            },
            {
                'targets': 10,
                'orderable': false,
                'searchable': false
            },
        ],
        "order": [[ 2, "asc" ]], // Order by date
        columns: [
            { data: 'id', name: 'product_region_types.id'},
            { data: 'typeName', name: 'types.name' },
            { data: 'regionName', name: 'regions.name' },
            { data: 'productName', name: 'products.name' },
            { data: 'year', name: 'product_region_types.year' },
            { data: 'planted_area', name: 'product_region_types.planted_area' },
            { data: 'harvested_area', name: 'product_region_types.harvested_area' },
            { data: 'production', name: 'product_region_types.production' },
            { data: 'value', name: 'product_region_types.value' },
            { data: 'yield', name: 'product_region_types.yield' },
            {
               defaultContent: '<a href="#" class="btn btn-primary btn-sm editProduction"><i class="fa fa-pencil fa-fw"></i></a>' +
                '<a href="#" style="margin-top: 5%;" class="btn btn-danger btn-sm deleteProduction"><i class="fa fa-trash fa-fw"></i></a>'
            }
        ]
    });

    // Handle the click on edit button
    table.on('click' , 'tr td .editProduction', function() {
        var row = $(this).closest('tr');
        var productionId = table.dataTable().fnGetData(row).id;
        document.location.href = "/producao/" + productionId + "/editar";
    });

    // Handle the click on delete button
    table.on('click' , 'tr td .deleteProduction', function() {
        var row = $(this).closest('tr');
        var productionId = table.dataTable().fnGetData(row).id;

        $.ajax({
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            method: 'DELETE',
            url: '/producao/' + productionId + '/deletar',
            dataType: 'json',
            async: false
        })
        .done(function(data) {
            if(data.status == 'success') {
                flashNotification('Dado Deletado.', 'success');
                row.remove();
            }
        });
    });
});
</script>
@endsection