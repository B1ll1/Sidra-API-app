<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="box-title">Produção</div>
            </div>
            @if(!strpos(Request::url(),'editar'))
            <div class="box-body">
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="productionTypeSelect">Tipo</label>
                        <select name="type_code" id="productionTypeSelect" class="form-control">
                            <option value=""></option>
                            @foreach($types as $type)
                            <option value="{{$type->code}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="productionProductSelect">Produto</label>
                        <select name="product_code" id="productionProductSelect" class="form-control">
                            <option value=""></option>

                            @foreach($products as $product)
                            <option value="{{$product->code}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="productionRegionSelect">UF</label>
                        <select name="region_code" id="productionRegionSelect" class="form-control">
                            <option value=""></option>

                            @foreach($ufs as $uf)
                            <option value="{{$uf->code}}">{{$uf->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="productionYearSelect">Ano</label>
                        <select name="year" id="productionYearSelect" class="form-control">
                            <option value=""></option>

                            @for($i = 2000; $i <= 2016; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                @endif
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="productionPlantedInput">Área Plantada</label>
                        <div class="input-group">
                            {!! Form::number('planted_area', null, ['id' => 'productionPlantedInput', 'class' => 'form-control', 'min' => 0]) !!}
                            <span class="input-group-addon" id="basic-addon1">Hectare</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productionHarvestedInput">Área Colhida</label>
                        <div class="input-group">
                            {!! Form::number('harvested_area', null, ['id' => 'productionHarvestedInput', 'class' => 'form-control', 'min' => 0]) !!}
                            <span class="input-group-addon" id="basic-addon1">Hectare</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productionInput">Quantidade Produzida</label>
                        <div class="input-group">
                            {!! Form::number('production', null, ['id' => 'productionInput', 'class' => 'form-control', 'min' => 0]) !!}
                            <span class="input-group-addon" id="basic-addon1">Toneladas</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productionValueInput">Valor</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">R$</span>
                            {!! Form::text('value', null, ['id' => 'productionValueInput', 'class' => 'form-control maskMoney']) !!}
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="productionYieldInput">Rendimento</label>
                        <div class="input-group">
                            {!! Form::number('yield', null, ['id' => 'productionYieldInput', 'class' => 'form-control', 'min' => 0]) !!}
                            <span class="input-group-addon" id="basic-addon2">kilograma/Hectare</span>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="box-footer">
                <div class="col-md-8 col-md-offset-2 col-xs-12 text-center">
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save fa-fw"></i> Salvar</button>&nbsp;&nbsp;
                    <a class="btn btn-danger btn-flat" href=""><i class="fa fa-undo fa-fw"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('specific_scripts')
@stop

@section('inline_scripts')
<script>
$(document).ready(function() {
    // $('.maskMoney').mask("#.##0", {reverse: true});

    $('#productionTypeSelect').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'Selecione o tipo de lavroura...'
    });

    $('#productionProductSelect').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'Selecione o produto...'
    });

    $('#productionRegionSelect').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'Selecione a Unidade da Federação...'
    });

    $('#productionYearSelect').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'Selecione o Ano...'
    });
});
</script>
@endsection