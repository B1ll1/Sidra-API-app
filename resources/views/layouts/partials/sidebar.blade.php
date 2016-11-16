<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      {{-- <! search form >
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> --}}
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        {{-- <li class="header">MAIN NAVIGATION</li> --}}

        <li>
          <a href="#">
            <i class="fa fa-dashboard fa-fw"></i> <span>Dashboard</span>
          </a>
        </li>

        <li>
          <a href="#">
            <i class="fa fa-home fa-fw"></i> <span>Produtos</span>
          </a>
        </li>

        <li>
          <a href="{{ route('product-region-type.create') }}">
            <i class="fa fa-plus fa-fw"></i>
            <span>Registrar Produção</span>
          </a>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-home fa-fw"></i> <span>Lavrouras</span>
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