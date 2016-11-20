@extends('layouts.master')

@section('specific_styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
@stop

@section('header_title')
<h1>
    <i class="fa fa-list-alt fa-fw"></i> Relatório de {{$dates[0]}} até {{$dates[1]}}
</h1>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <h3>Área Plantada</h3>
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                        <th>Produtos</th>
                        @foreach($productions as $key => $production)
                            <th>{{$key}}</th>
                        @endforeach
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key => $product)
                        <tr>
                            <th>{{$product}}</th>
                            {{-- @foreach($productions as $key2 => $production)
                            <td>{{$productions[$key2][$product]}}</td>
                            @endforeach --}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@stop

@section('specific_scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
@stop

@section('inline_scripts')

@endsection