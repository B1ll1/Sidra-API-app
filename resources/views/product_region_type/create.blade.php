@extends('layouts.master')

@section('specific_styles')
@stop

@section('header_title')
<h1>
    <i class="fa fa-plus fa-fw"></i>Novo registro de produção
</h1>

<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
    <li><a href="#"></a><i class="fa fa-calculator fa-fw"></i> Produção</li>
    <li class="active">Novo</li>
</ol>
@stop

@section('content')
    <section class="content">
        {!! Form::model(new App\Product_Region_Type, ['route' => ['product-region-type.store'], 'method' => 'POST']) !!}
            @include('product_region_type.partials._form')
        {!! Form::close() !!}
    </section>
@stop