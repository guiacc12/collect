@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Painel de Controle</h1>
    </div>
    <!-- Primeira Linha: Estatísticas Principais (3 cards distribuídos) -->
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-handshake"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Colaboradores Ativos</h4>
            </div>
            <div class="card-body">
              {{ \App\Models\Colaborador::count() }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-dollar-sign"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Vendas do Mês</h4>
            </div>
            <div class="card-body">
              {{ \App\Models\Venda::whereMonth('created_at', now()->month)->count() }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-info">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Vendedores Ativos</h4>
            </div>
            <div class="card-body">
              {{ \App\Models\Vendedor::count() }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Segunda Linha: Top Performers -->
    <div class="row">
      <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fas fa-trophy text-success"></i> Top Vendedor</h4>
          </div>
          <div class="card-body">
            @php
              $topVendedor = \App\Models\Vendedor::with('vendas')
                ->get()
                ->sortByDesc(function($vendedor) {
                  return $vendedor->vendas->filter(function($venda) {
                    return $venda->created_at->month == now()->month
                           && $venda->created_at->year == now()->year
                           && $venda->status == true; // Apenas vendas confirmadas
                  })->sum('valor_venda');
                })
                ->first();
            @endphp
            @if($topVendedor)
              @php
                $vendasDoMes = $topVendedor->vendas->filter(function($venda) {
                  return $venda->created_at->month == now()->month
                         && $venda->created_at->year == now()->year
                         && $venda->status == true; // Apenas vendas confirmadas
                });
                $totalVendas = $vendasDoMes->sum('valor_venda');

                // Debug temporário - remover depois
                if($vendasDoMes->isEmpty()) {
                  // Verificar se há vendas sem filtro de status
                  $todasVendasDoMes = $topVendedor->vendas->filter(function($venda) {
                    return $venda->created_at->month == now()->month
                           && $venda->created_at->year == now()->year;
                  });
                  if($todasVendasDoMes->isNotEmpty()) {
                    $totalVendas = $todasVendasDoMes->sum('valor_venda');
                    $vendasDoMes = $todasVendasDoMes;
                  }
                }
              @endphp
              <div class="d-flex justify-content-between">
                <div>
                  <h6 class="text-muted">Maior Vendas do Mês</h6>
                  <h5 class="text-dark">{{ $topVendedor->nome }}</h5>
                </div>
                <div class="text-right">
                  <small class="text-muted">Vendas este mês</small>
                  <div class="badge badge-success">
                    <i class="fas fa-medal"></i> R$ {{ number_format($totalVendas, 2, ',', '.') }}
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-center">
                <small class="text-muted">{{ $vendasDoMes->count() }} vendas realizadas</small>
              </div>
            @else
              <p class="text-muted">Nenhum vendedor encontrado</p>
            @endif
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fas fa-crown text-warning"></i> Top Colaborador</h4>
          </div>
          <div class="card-body">
            @php
              $topColaborador = \App\Models\Colaborador::with('colaboradorServicos')
                ->get()
                ->sortByDesc(function($colaborador) {
                  return $colaborador->colaboradorServicos->sum(function($servico) {
                    return $servico->valor * $servico->quantidade;
                  });
                })
                ->first();
            @endphp
            @if($topColaborador)
              <div class="d-flex justify-content-between">
                <div>
                  <h6 class="text-muted">Maior Produtor</h6>
                  <h5 class="text-dark">{{ $topColaborador->nome }}</h5>
                </div>
                <div class="text-right">
                  <small class="text-muted">Total gerado</small>
                  <div class="badge badge-warning">
                    <i class="fas fa-star"></i> R$ {{ number_format($topColaborador->colaboradorServicos->sum(function($s) { return $s->valor * $s->quantidade; }), 2, ',', '.') }}
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-center">
                <small class="text-muted">{{ $topColaborador->colaboradorServicos->sum('quantidade') }} peças produzidas</small>
              </div>
            @else
              <p class="text-muted">Nenhum colaborador encontrado</p>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Terceira Linha: Informações Gerais -->
    <div class="row">
      <div class="col-lg-4 col-md-6 col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fas fa-chart-line text-primary"></i> Receita do Mês</h4>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="text-muted">Total Estimado</h6>
                <h4 class="text-success">
                  R$ {{ number_format(\App\Models\ColaboradorServico::whereMonth('created_at', now()->month)->sum(\DB::raw('valor * quantidade')), 2, ',', '.') }}
                </h4>
              </div>
              <div class="text-right">
                <small class="text-muted">Este mês</small>
                <div class="badge badge-success">
                  <i class="fas fa-arrow-up"></i> +{{ \App\Models\ColaboradorServico::whereMonth('created_at', now()->month)->count() }} serviços
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fas fa-calendar-check text-info"></i> Produção no Mês</h4>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="text-muted">Serviços Realizados</h6>
                <h4 class="text-info">
                  {{ \App\Models\ColaboradorServico::whereMonth('data_producao', now()->month)->whereYear('data_producao', now()->year)->sum('quantidade') }} peças
                </h4>
              </div>
              <div class="text-right">
                <small class="text-muted">Este mês</small>
                <div class="badge badge-info">
                  {{ \App\Models\ColaboradorServico::whereMonth('data_producao', now()->month)->whereYear('data_producao', now()->year)->count() }} registros
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-12 col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fas fa-building text-dark"></i> SUPREMA - Informações</h4>
          </div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-4">
                <i class="fas fa-calendar-alt text-info fa-2x mb-2"></i>
                <h6 class="text-muted">Sistema Online</h6>
                <small>{{ now()->format('d/m/Y') }}</small>
              </div>
              <div class="col-4">
                <i class="fas fa-shield-alt text-success fa-2x mb-2"></i>
                <h6 class="text-muted">Segurança</h6>
                <small>Ativa</small>
              </div>
              <div class="col-4">
                <i class="fas fa-database text-warning fa-2x mb-2"></i>
                <h6 class="text-muted">Backup</h6>
                <small>Automático</small>
              </div>
            </div>
            <hr>
            <div class="text-center">
              <p class="text-muted mb-1">
                <i class="fas fa-heart text-danger"></i>
                Sistema de Gestão SUPREMA
              </p>
              <small class="text-muted">Versão 1.0 - Desenvolvido para excelência operacional</small>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
@endsection


