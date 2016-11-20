<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        {{-- <li class="header">MAIN NAVIGATION</li> --}}

        <li class="treeview {{ strpos(Request::url(), 'producao') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-dashboard fa-fw"></i> <span>Produção Agrícola</span>
          </a>

          <ul class="treeview-menu">
            <li class="{{ strpos(Request::url(), 'cadastrar') ? 'active' : '' }}">
              <a href="{{ route('product-region-type.create') }}">
                <i class="fa fa-plus fa-fw"></i>
                <span>Registrar Produção</span>
              </a>
            </li>

            <li class="{{ strpos(Request::url(), 'estados') ? 'active' : '' }}">
              <a href="{{ route('product-region-type.index') }}">
                <i class="fa fa-eye fa-fw"></i>
                <span>Produções por Estados</span>
              </a>
            </li>

            <li class="{{ strpos(Request::url(), 'regiao') ? 'active' : '' }}">
              <a href="{{ route('product-region-type.bigRegion') }}">
                <i class="fa fa-eye fa-fw"></i>
                <span>Produções por Grande Região</span>
              </a>
            </li>

            <li class="{{ strpos(Request::url(), 'pais') ? 'active' : '' }}">
              <a href="{{ route('product-region-type.country') }}">
                <i class="fa fa-eye fa-fw"></i>
                <span>Produções do Brasil</span>
              </a>
            </li>
          </ul>
        </li>

        <li class="{{ strpos(Request::url(), 'analise') ? 'active' : '' }}">
          <a href="{{ route('report.productionForRegionChart') }}">
            <i class="fa fa-bar-chart fa-fw"></i>
            <span>Relatórios</span>
          </a>
        </li>

      </ul>

    </section>
    <!-- /.sidebar -->
  </aside>