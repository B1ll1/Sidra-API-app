@extends('layouts.master')

@section('specific_styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
@stop

@section('header_title')
<h1>
    <i class="fa fa-list-alt fa-fw"></i> Análise / Relatórios
</h1>

<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard fa-fw"></i> Produção Agrícola</a></li>
    <li class="active">Análise / Relatórios</li>
</ol>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="box-title">Relatórios</div>
                    </div>
                    <div class="box-body">
                        <div class="container-fluid">
                            {!! Form::open(['route' => 'report.generateReport', 'method' => 'POST', 'class' => 'form-hotizontal']) !!}
                            <div class="form-group">
                                <label for="">Produtos</label>
                                <div class="pull-right"><input type="checkbox" id="allProducts"> Selecionar Todos</div>
                                <select name="products[]" id="productsSelect" class="form-control" multiple>
                                    @foreach($products as $product)
                                    <option value="{{$product->code}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Estados</label>
                                <div class="pull-right"><input type="checkbox" id="allUfs"> Selecionar Todos</div>
                                <select name="regions[]" id="ufsSelect" class="form-control" multiple>
                                    @foreach($ufs as $uf)
                                    <option value="{{$uf->code}}">{{$uf->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label for="">Data Inicial</label>
                                        <select name="date_start" id="dateStartSelect" class="form-control">
                                            <option value=""></option>
                                            @foreach($years as $year)
                                            <option value="{{$year['id']}}">{{$year['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="">Data Final</label>
                                        <select name="date_end" id="dateEndSelect" class="form-control">
                                            <option value=""></option>
                                            @foreach($years as $year)
                                            <option value="{{$year['id']}}">{{$year['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-xs-6">
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="fa fa-save fa-fw"></i>
                                Salvar
                            </button>
                        </div>
                        <div class="col-xs-6">
                            <a href="#" class="btn btn-danger">
                                <i class="fa fa-undo fa-fw"></i>
                                Voltar
                            </a>
                        </div>
                        {!! Form::close() !!}
                    </div>
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
    $('#productsSelect').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'Selecione os produtos que deseja inserir no relatório...',
    });

    $('#ufsSelect').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'Selecione os estados que deseja inserir no relatório...',
    });

    $('#dateStartSelect').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'Ano inicial...',
    });

    $('#dateEndSelect').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'Ano final...',
    });
});
</script>

<script>
$(document).ready(function() {

    $('#allProducts').click(function() {
        if($('#allProducts').is(':checked')) {
            $('#productsSelect > option').prop('selected', 'selected');
            $('#productsSelect').trigger('change');
        }
        else {
            $('#productsSelect > option').removeAttr('selected');
            $('#productsSelect').trigger('change');
        }
    });

    $('#allUfs').click(function() {
        if($('#allUfs').is(':checked')) {
            $('#ufsSelect > option').prop('selected', 'selected');
            $('#ufsSelect').trigger('change');
        }
        else {
            $('#ufsSelect > option').removeAttr('selected');
            $('#ufsSelect').trigger('change');
        }
    });
});
</script>
@endsection