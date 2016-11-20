@extends('layouts.master')

@section('specific_styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
@stop

@section('header_title')
<h1>
    <i class="fa fa-list-alt fa-fw"></i> Relatório do Brasil
</h1>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="row">
                    <div class="col-xs-6">
                        <select name="region" id="regionSelect" class="form-control">
                            @foreach($regions->sortBy('name') as $region)
                            <option value="{{$region->code}}">{{$region->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <select name="year" id="yearSelect" class="form-control">
                            @for($i = 1995; $i <= 2016; $i++)
                            <option value="{{$i}}" {{$i == 2000 ? 'selected' : ''}}>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row" style="margin-top: 2%;">
                    <div class="col-xs-6 col-xs-offset-3">
                        <select name="attribute" id="attributeSelect" class="form-control">
                            <option value="0">Produção (em Toneladas)</option>
                            <option value="1">Rendimento (em kg/hectare)</option>
                            <option value="2">Área Plantada x Área Colhida</option>
                        </select>
                    </div>
                </div>

                <section id="tempChart" style="background-color: #fff; height: 1000px; margin-top: 3%;"></section>

                <section id="permChart" style="background-color: #fff; height: 1000px; margin-top: 3%;"></section>

            </div>
        </div>
    </section>
@stop

@section('specific_scripts')
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/highcharts-more.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script src="/assets/libs/export-csv/export-csv.js"></script>
@stop

@section('inline_scripts')
<script>
$(document).ready(function () {
    var selectedRegion = $('#regionSelect option:selected').text();
    var selectedYear   = $('#yearSelect option:selected').text();
    var categories     = {!! json_encode(array_values($categories), JSON_UNESCAPED_UNICODE) !!};

    // Build the chart
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'tempChart',
            type: 'bar',
            zoomType: 'xy'
        },
        title: {
            text: 'Produção Agrícola - Temporária'
        },
        xAxis: {
            categories: categories,
            reversed: false,
            crosshair: true,
            max: 30
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Produção (Toneladas)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: []
    });

    var regionCode = $('#regionSelect option:selected').val();
    var year       = $('#yearSelect option:selected').val();
    var attr       = $('#attributeSelect option:selected').val();

    $.ajax({
       url: '/analise/producao-por-pais/dados',
       type: "GET",
       dataType: "json",
       data : {
            code: regionCode,
            year: year,
            attr: attr
       },
       success: function(data) {
           if(attr == 0) {
                chart.addSeries({
                    name: "Produção (Toneladas)",
                    data: data['temp']
                });
           }
           else if(attr == 1) {
                chart.addSeries({
                    name: "Rendimento (kg/hectare)",
                    data: data['temp']
                });
           }
           else {
                chart.addSeries({
                    name: "Área Plantada",
                    data: data['planted-t']
                });
                chart.addSeries({
                    name: "Área Colhida",
                    data: data['harvested-t']
                });
           }
       },
       cache: false
    });

    $('#regionSelect').change(function() {
        var regionCode = $('#regionSelect option:selected').val();
        var year       = $('#yearSelect option:selected').val();
        var attr       = $('#attributeSelect option:selected').val();

        $.ajax({
            url: '/analise/producao-por-pais/dados',
            type: "GET",
            dataType: "json",
            data : {
                code: regionCode,
                year: year,
                attr: attr
            },
            success: function(data) {
                while(chart.series.length > 0)
                    chart.series[0].remove(true);

                if(attr == 0) {
                    chart.addSeries({
                        name: "Produção (Toneladas)",
                        data: data['temp']
                    });
                }
                else if(attr == 1) {
                    chart.addSeries({
                        name: "Rendimento (kg/hectare)",
                        data: data['temp']
                    });
                }
                else {
                    chart.addSeries({
                        name: "Área Plantada",
                        data: data['planted-t']
                    });
                    chart.addSeries({
                        name: "Área Colhida",
                        data: data['harvested-t']
                    });
                }
            },
            cache: false
        });
    });

    $('#yearSelect').change(function() {
        var regionCode = $('#regionSelect option:selected').val();
        var year       = $('#yearSelect option:selected').val();
        var attr       = $('#attributeSelect option:selected').val();

        $.ajax({
            url: '/analise/producao-por-pais/dados',
            type: "GET",
            dataType: "json",
            data : {
                code: regionCode,
                year: year,
                attr: attr
            },
            success: function(data) {
                while(chart.series.length > 0)
                    chart.series[0].remove(true);

                if(attr == 0) {
                    chart.addSeries({
                        name: "Produção (Toneladas)",
                        data: data['temp']
                    });
                }
                else if(attr == 1) {
                    chart.addSeries({
                        name: "Rendimento (kg/hectare)",
                        data: data['temp']
                    });
                }
                else {
                    chart.addSeries({
                        name: "Área Plantada",
                        data: data['planted-t']
                    });
                    chart.addSeries({
                        name: "Área Colhida",
                        data: data['harvested-t']
                    });
                }
            },
            cache: false
        });
    });

    $('#attributeSelect').change(function() {
        var regionCode = $('#regionSelect option:selected').val();
        var year       = $('#yearSelect option:selected').val();
        var attr       = $('#attributeSelect option:selected').val();

        $.ajax({
            url: '/analise/producao-por-pais/dados',
            type: "GET",
            dataType: "json",
            data : {
                code: regionCode,
                year: year,
                attr: attr
            },
            success: function(data) {
                while(chart.series.length > 0)
                    chart.series[0].remove(true);

                if(attr == 0) {
                    chart.addSeries({
                        name: "Produção (Toneladas)",
                        data: data['temp']
                    });
                }
                else if(attr == 1) {
                    chart.addSeries({
                        name: "Rendimento (kg/hectare)",
                        data: data['temp']
                    });
                }
                else {
                    chart.addSeries({
                        name: "Área Plantada",
                        data: data['planted-t']
                    });
                    chart.addSeries({
                        name: "Área Colhida",
                        data: data['harvested-t']
                    });
                }
            },
            cache: false
        });

        if(attr == 0)
            chart.yAxis[0].update({title: {text: 'Produção (Toneladas)'}});
        else if(attr == 1)
            chart.yAxis[0].update({title: {text: 'Rendimento (kg/hectare)'}});
        else
            chart.yAxis[0].update({title: {text: 'Área Plantada X Área Colhida (Hectare)'}});
    });
});
</script>

<script>
$(document).ready(function () {
    var selectedRegion = $('#regionSelect option:selected').text();
    var selectedYear   = $('#yearSelect option:selected').text();
    var categoriesPerm = {!! json_encode(array_values($categoriesPerm), JSON_UNESCAPED_UNICODE) !!};

    // Build the chart
    var chart2 = new Highcharts.Chart({
        chart: {
            renderTo: 'permChart',
            type: 'bar',
            zoom: 'xy'
        },
        title: {
            text: 'Produção Agrícola - Permanente'
        },
        xAxis: {
            categories: categoriesPerm,
            reversed: false,
            crosshair: true,
            max: 34
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Produção'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: []
    });

    var regionCode = $('#regionSelect option:selected').val();
    var year       = $('#yearSelect option:selected').val();
    var attr       = $('#attributeSelect option:selected').val();

    $.ajax({
       url: '/analise/producao-por-pais/dados',
       type: "GET",
       dataType: "json",
       data : {
            code: regionCode,
            year: year,
            attr: attr
       },
       success: function(data) {
           if(attr == 0) {
               chart2.addSeries({
                   name: "Produção (Toneladas)",
                   data: data['perm']
               });
           }
           else if(attr == 1) {
               chart2.addSeries({
                   name: "Rendimento (kg/hectare)",
                   data: data['perm']
               });
           }
           else {
                chart2.addSeries({
                    name: "Área Plantada",
                    data: data['planted-p']
                });
                chart2.addSeries({
                    name: "Área Colhida",
                    data: data['harvested-p']
                });
           }
       },
       cache: false
    });

    $('#regionSelect').change(function() {
        var regionCode = $('#regionSelect option:selected').val();
        var year       = $('#yearSelect option:selected').val();
        var attr       = $('#attributeSelect option:selected').val();

        $.ajax({
            url: '/analise/producao-por-pais/dados',
            type: "GET",
            dataType: "json",
            data : {
                code: regionCode,
                year: year,
                attr: attr
            },
            success: function(data) {
                while(chart2.series.length > 0)
                    chart2.series[0].remove(true);

                if(attr == 0) {
                    chart2.addSeries({
                        name: "Produção (Toneladas)",
                        data: data['perm']
                    });
                }
                else if(attr == 1) {
                    chart2.addSeries({
                        name: "Rendimento (kg/hectare)",
                        data: data['perm']
                    });
                }
                else {
                     chart2.addSeries({
                         name: "Área Plantada",
                         data: data['planted-p']
                     });
                     chart2.addSeries({
                         name: "Área Colhida",
                         data: data['harvested-p']
                     });
                }
            },
            cache: false
        });
    });

    $('#yearSelect').change(function() {
        var regionCode = $('#regionSelect option:selected').val();
        var year       = $('#yearSelect option:selected').val();
        var attr       = $('#attributeSelect option:selected').val();

        $.ajax({
            url: '/analise/producao-por-pais/dados',
            type: "GET",
            dataType: "json",
            data : {
                code: regionCode,
                year: year,
                attr: attr
            },
            success: function(data) {
                while(chart2.series.length > 0)
                    chart2.series[0].remove(true);

                if(attr == 0) {
                    chart2.addSeries({
                        name: "Produção (Toneladas)",
                        data: data['perm']
                    });
                }
                else if(attr == 1) {
                    chart2.addSeries({
                        name: "Rendimento (kg/hectare)",
                        data: data['perm']
                    });
                }
                else {
                     chart2.addSeries({
                         name: "Área Plantada",
                         data: data['planted-p']
                     });
                     chart2.addSeries({
                         name: "Área Colhida",
                         data: data['harvested-p']
                     });
                }
            },
            cache: false
        });
    });

    $('#attributeSelect').change(function() {
        var regionCode = $('#regionSelect option:selected').val();
        var year       = $('#yearSelect option:selected').val();
        var attr       = $('#attributeSelect option:selected').val();

        $.ajax({
            url: '/analise/producao-por-pais/dados',
            type: "GET",
            dataType: "json",
            data : {
                code: regionCode,
                year: year,
                attr: attr
            },
            success: function(data) {
                while(chart2.series.length > 0)
                    chart2.series[0].remove(true);

                if(attr == 0) {
                    chart2.addSeries({
                        name: "Produção (Toneladas)",
                        data: data['perm']
                    });
                }
                else if(attr == 1) {
                    chart2.addSeries({
                        name: "Rendimento (kg/hectare)",
                        data: data['perm']
                    });
                }
                else {
                    chart2.addSeries({
                        name: "Área Plantada",
                        data: data['planted-p']
                    });
                    chart2.addSeries({
                        name: "Área Colhida",
                        data: data['harvested-p']
                    });
                }
            },
            cache: false
        });

        if(attr == 0)
            chart2.yAxis[0].update({title: {text: 'Produção (Toneladas)'}});
        else if(attr == 1)
            chart2.yAxis[0].update({title: {text: 'Rendimento (kg/hectare)'}});
        else
            chart2.yAxis[0].update({title: {text: 'Área Plantada X Área Colhida (Hectare)'}});
    });
});
</script>
@endsection