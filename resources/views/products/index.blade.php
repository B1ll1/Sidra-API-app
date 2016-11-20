@extends('layouts.master')

@section('content')

<form action="{{route('import')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <div class="col-md-4">
                <div class="col-md-8">
                    <input id="choose-file" type="file" name="import_file[]" multiple class="filestyle form-control" data-input="false" data-buttonText="Escolher Arquivos"/>
                    <button class="btn btn-primary ">Importar Arquivos</button>
                </div>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
</form>

@stop