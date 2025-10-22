<div class="main-sidebar sidebar-style-2" style="background: #e5dad4">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" style="color: #203a4e">COLLECT TEC'</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('admin.dashboard') }}">C'T</a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header" style="color: #203a4e">PAINEL DE CONTROLE</li>
        <li class="dropdown active">
          <a href="#" class="nav-link has-dropdown" style="color: #203a4e" ><i class="fas fa-fire"></i><span>PAINEL</span></a>
          <ul class="dropdown-menu" >
            <li class=active ><a class="nav-link" href="{{ route('slider.index') }}" style="color: #203a4e">Banners</a></li>
            <li><a class="nav-link" href="{{ route('promocao.index') }}" style="color: #203a4e">Promoções</a></li>
          </ul>
        </li>
        <li class="menu-header" style="color: #203a4e">Starter</li>
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown" style="color: #203a4e"><i class="fas fa-folder-plus"></i> <span>Produtos</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('categoria.index') }}" style="color: #203a4e">Categorias</a></li>
            <li><a class="nav-link" href="{{ route('produto.index') }}" style="color: #203a4e">Produtos</a></li>
          </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown" style="color: #203a4e"><i class="fas fa-briefcase"></i> <span>Relatórios</span></a>
            <ul class="dropdown-menu">
              <li><a class="nav-link" href="{{ route('admin.faturamento.index') }}" style="color: #203a4e">Faturamento/Vendas</a></li>
              <li><a class="nav-link" href="{{ route('vendedor.index') }}" style="color: #203a4e">Vendedores</a></li>
              <li><a class="nav-link" href="{{ route('admin.colaboradores.index') }}" style="color: #203a4e">Colaboradores</a></li>
            </ul>
          </li>






      </ul>

    </aside>
  </div>
