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
    <li class="active">editar</li>
</ol>
@stop

@section('content')
    <section class="content">
        {!! Form::model($production, ['route' => ['product-region-type.update', $production->id], 'method' => 'PUT']) !!}
            @include('product_region_type.partials._form')
        {!! Form::close() !!}
    </section>
@stop