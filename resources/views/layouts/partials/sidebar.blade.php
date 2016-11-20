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

            <li class="{{ strpos(Request::url(), 'todos') ? 'active' : '' }}">
              <a href="{{ route('product-region-type.index') }}">
                <i class="fa fa-eye fa-fw"></i>
                <span>Produções por UF</span>
              </a>
            </li>
          </ul>
        </li>

        <li class="{{ strpos(Request::url(), 'analise') ? 'active' : '' }}">
          <a href="{{ route('report.index') }}">
            <i class="fa fa-bar-chart fa-fw"></i>
            <span>Relatórios</span>
          </a>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-home fa-fw"></i> <span>Lavouras</span>
          </a>

          <ul class="treeview-menu">
            <li class="active">
              <a href="#">
                <i class="fa fa-home fa-fw"></i> Permanente
              </a>
            </li>
            <li class="active">
              <a href="#">
                <i class="fa fa-home fa-fw"></i> Temporária
              </a>
            </li>
          </ul>
        </li>

      </ul>

    </section>
    <!-- /.sidebar -->
  </aside>