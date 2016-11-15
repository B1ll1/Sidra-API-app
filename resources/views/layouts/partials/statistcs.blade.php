<div class="row">
  <div class="col-lg-4 col-xs-6">
    <!-- small box -->
    <a href="{{ route('room.index') }}">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>Quartos</h3>

          <p>
            <span style="font-size: 2.1em; font-weight: 800;">
              {{ $republic->rooms->count() }}
            </span>
          </p>
        </div>
        <div class="icon">
          <i class="fa fa-bed fa-fw"></i>
        </div>
        <span class="small-box-footer">{{ $republic->users->count() != 0 ? 'Detalhes' : 'Criar Quartos!'}} <i class="fa fa-arrow-circle-right"></i></span>
      </div>
    </a>
  </div>
  <!-- ./col -->

  <div class="col-lg-4 col-xs-6">
    <a href="{{ route('bill.index') }}">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>Gastos</h3>

          <p><span style="font-size: 2.1em; font-weight: 800;">&nbsp;</span></p>
        </div>
        <div class="icon">
          <i class="fa fa-calculator fa-fw"></i>
        </div>
        <span class="small-box-footer">
          Detalhes <i class="fa fa-arrow-circle-right"></i>
        </span>
      </div>
    </a>
  </div>
  <!-- ./col -->

  <div class="col-lg-4 col-xs-12">
    <a href="{{ route('bill.details') }}">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h4>{{ $republic->getCurrentMonth() }}</h4>

          <p>
            <span style="font-size: 1.3em; font-weight: 800;" data-toggle="tooltip" title="Total dos gastos do mês corrente. Apenas gastos onde todos participaram.">
              R$ {{ number_format($republic->getMonthlyCosts(), 2, ',', '.') }}
            </span><br>
            <span data-toggle="tooltip" title="Valor da sua parte para o mês corrente. Contas de outro mês não entram no cálculo!">Sua Parte: <span style="text-decoration: underline;">R$ {{ number_format(Auth::user()->getMyMonthlyCost() + Auth::user()->getMyRent(), 2, ',', '.') }}</span></span>
          </p>
        </div>
        <div class="icon">
          <i class="fa fa-archive"></i>
        </div>
        <span class="small-box-footer">
          Detalhes da Caixinha <i class="fa fa-arrow-circle-right fa-fw"></i>
        </span>
      </div>
    </a>
  </div>
  <!-- ./col -->
</div>
<!-- /.row -->