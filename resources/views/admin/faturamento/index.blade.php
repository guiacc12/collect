@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Relatório de Faturamento</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Faturamento</div>
        </div>
    </div>

    <div class="section-body">
        <!-- Filtros de Data -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-filter text-primary"></i> Filtros de Período</h4>
                    </div>
                    <div class="card-body">
                        <form id="formFiltros" class="row">
                            <div class="col-md-3">
                                <label for="data_inicio">Data Início:</label>
                                <input type="date" id="data_inicio" class="form-control" value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="data_fim">Data Fim:</label>
                                <input type="date" id="data_fim" class="form-control" value="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="status_filtro">Status:</label>
                                <select id="status_filtro" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="1">Concluídas</option>
                                    <option value="0">Em Aberto</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <div class="d-flex">
                                    <button type="button" id="btnFiltrar" class="btn btn-primary me-2">
                                        <i class="fas fa-search"></i> Filtrar
                                    </button>
                                    <button type="button" id="btnLimpar" class="btn btn-secondary">
                                        <i class="fas fa-eraser"></i> Limpar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards de Estatísticas Principais -->
        <div class="row" id="cardsEstatisticas">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Vendas Concluídas</h4>
                        </div>
                        <div class="card-body" id="vendasConcluidas">
                            {{ \App\Models\Venda::where('status', true)->whereMonth('created_at', now()->month)->count() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Vendas em Aberto</h4>
                        </div>
                        <div class="card-body" id="vendasAberto">
                            {{ \App\Models\Venda::where('status', false)->whereMonth('created_at', now()->month)->count() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Faturado</h4>
                        </div>
                        <div class="card-body" id="totalFaturado">
                            R$ {{ number_format(\App\Models\Venda::where('status', true)->whereMonth('created_at', now()->month)->sum('valor_venda'), 2, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Ticket Médio</h4>
                        </div>
                        <div class="card-body" id="ticketMedio">
                            @php
                                $vendas = \App\Models\Venda::where('status', true)->whereMonth('created_at', now()->month);
                                $total = $vendas->sum('valor_venda');
                                $quantidade = $vendas->count();
                                $ticketMedio = $quantidade > 0 ? $total / $quantidade : 0;
                            @endphp
                            R$ {{ number_format($ticketMedio, 2, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards de Análises Detalhadas -->
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-map-marker-alt text-success"></i> Estado Top Vendas</h4>
                    </div>
                    <div class="card-body" id="estadoTopVendas">
                        @php
                            $estadoTop = \App\Models\Venda::select('estado', \DB::raw('COUNT(*) as total'))
                                ->where('status', true)
                                ->whereMonth('created_at', now()->month)
                                ->groupBy('estado')
                                ->orderByDesc('total')
                                ->first();
                        @endphp
                        @if($estadoTop)
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-muted">Estado Líder</h6>
                                    <h5 class="text-dark">{{ $estadoTop->estado }}</h5>
                                </div>
                                <div class="text-right">
                                    <small class="text-muted">Vendas</small>
                                    <div class="badge badge-success">
                                        <i class="fas fa-trophy"></i> {{ $estadoTop->total }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-muted">Nenhuma venda encontrada</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-calendar-week text-info"></i> Performance do Período</h4>
                    </div>
                    <div class="card-body" id="performanceSemanal">
                        @php
                            $vendasSemana = \App\Models\Venda::where('status', true)
                                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                ->sum('valor_venda');
                            $qtdSemana = \App\Models\Venda::where('status', true)
                                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                ->count();
                        @endphp
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center">
                                    <h5 class="text-info">{{ $qtdSemana }}</h5>
                                    <small class="text-muted">Vendas no Período</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <h5 class="text-success">R$ {{ number_format($vendasSemana, 2, ',', '.') }}</h5>
                                    <small class="text-muted">Faturamento do Período</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @php
                            $metaSemanal = 50000; // Meta semanal de faturamento
                            $percentualMeta = $metaSemanal > 0 ? min(($vendasSemana / $metaSemanal) * 100, 100) : 0;
                        @endphp
                        <div class="progress mb-2">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percentualMeta }}%" aria-valuenow="{{ $percentualMeta }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">Meta: R$ {{ number_format($metaSemanal, 2, ',', '.') }} ({{ number_format($percentualMeta, 1) }}%)</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-chart-pie text-warning"></i> Status das Vendas</h4>
                    </div>
                    <div class="card-body" id="statusVendas">
                        @php
                            $totalVendas = \App\Models\Venda::whereMonth('created_at', now()->month)->count();
                            $vendasConcluidas = \App\Models\Venda::where('status', true)->whereMonth('created_at', now()->month)->count();
                            $vendasAbertas = $totalVendas - $vendasConcluidas;
                            $percentualConcluidas = $totalVendas > 0 ? ($vendasConcluidas / $totalVendas) * 100 : 0;
                        @endphp
                        <div class="row text-center">
                            <div class="col-6">
                                <h5 class="text-success">{{ number_format($percentualConcluidas, 1) }}%</h5>
                                <small class="text-muted">Concluídas</small>
                            </div>
                            <div class="col-6">
                                <h5 class="text-warning">{{ number_format(100 - $percentualConcluidas, 1) }}%</h5>
                                <small class="text-muted">Em Aberto</small>
                            </div>
                        </div>
                        <hr>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-success" style="width: {{ $percentualConcluidas }}%"></div>
                            <div class="progress-bar bg-warning" style="width: {{ 100 - $percentualConcluidas }}%"></div>
                        </div>
                        <small class="text-muted">Total: {{ $totalVendas }} vendas no período</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards de Análise por Vendedor e Cidade -->
        <div class="row">
            <div class="col-lg-6 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-users text-primary"></i> Top 5 Vendedores</h4>
                    </div>
                    <div class="card-body" id="topVendedores">
                        @php
                            $topVendedores = \App\Models\Vendedor::with(['vendas' => function($query) {
                                $query->where('status', true)->whereMonth('created_at', now()->month);
                            }])->get()->map(function($vendedor) {
                                return [
                                    'nome' => $vendedor->nome,
                                    'total' => $vendedor->vendas->sum('valor_venda'),
                                    'quantidade' => $vendedor->vendas->count()
                                ];
                            })->sortByDesc('total')->take(5);
                        @endphp
                        @if($topVendedores->count() > 0)
                            @foreach($topVendedores as $vendedor)
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <strong>{{ $vendedor['nome'] }}</strong>
                                        <small class="text-muted d-block">{{ $vendedor['quantidade'] }} vendas</small>
                                    </div>
                                    <div class="text-right">
                                        <span class="badge badge-primary">R$ {{ number_format($vendedor['total'], 2, ',', '.') }}</span>
                                    </div>
                                </div>
                                @if(!$loop->last)<hr>@endif
                            @endforeach
                        @else
                            <p class="text-muted">Nenhuma venda encontrada no período</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-city text-secondary"></i> Top 5 Cidades</h4>
                    </div>
                    <div class="card-body" id="topCidades">
                        @php
                            $topCidades = \App\Models\Venda::select('cidade', \DB::raw('COUNT(*) as quantidade'), \DB::raw('SUM(valor_venda) as total'))
                                ->where('status', true)
                                ->whereMonth('created_at', now()->month)
                                ->groupBy('cidade')
                                ->orderByDesc('total')
                                ->take(5)
                                ->get();
                        @endphp
                        @if($topCidades->count() > 0)
                            @foreach($topCidades as $cidade)
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <strong>{{ $cidade->cidade }}</strong>
                                        <small class="text-muted d-block">{{ $cidade->quantidade }} vendas</small>
                                    </div>
                                    <div class="text-right">
                                        <span class="badge badge-secondary">R$ {{ number_format($cidade->total, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                                @if(!$loop->last)<hr>@endif
                            @endforeach
                        @else
                            <p class="text-muted">Nenhuma venda encontrada no período</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Filtrar dados
    $('#btnFiltrar').on('click', function() {
        const dataInicio = $('#data_inicio').val();
        const dataFim = $('#data_fim').val();
        const status = $('#status_filtro').val();

        if (!dataInicio || !dataFim) {
            toastr.warning('Por favor, selecione o período de datas.');
            return;
        }

        if (new Date(dataInicio) > new Date(dataFim)) {
            toastr.error('A data de início não pode ser maior que a data fim.');
            return;
        }

        // Mostrar loading
        toastr.info('Filtrando dados...');

        // Requisição AJAX
        $.ajax({
            url: '{{ route("admin.faturamento.filtrar") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                data_inicio: dataInicio,
                data_fim: dataFim,
                status: status
            },
            success: function(response) {
                // Atualizar cards principais
                $('#vendasConcluidas').text(response.vendasConcluidas);
                $('#vendasAberto').text(response.vendasAberto);
                $('#totalFaturado').text('R$ ' + response.totalFaturado);
                $('#ticketMedio').text('R$ ' + response.ticketMedio);

                // Atualizar estado top
                if (response.estadoTop) {
                    $('#estadoTopVendas').html(`
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted">Estado Líder</h6>
                                <h5 class="text-dark">${response.estadoTop.estado}</h5>
                            </div>
                            <div class="text-right">
                                <small class="text-muted">Vendas</small>
                                <div class="badge badge-success">
                                    <i class="fas fa-trophy"></i> ${response.estadoTop.total}
                                </div>
                            </div>
                        </div>
                    `);
                } else {
                    $('#estadoTopVendas').html('<p class="text-muted">Nenhuma venda encontrada</p>');
                }

                // Atualizar performance do período
                $('#performanceSemanal').html(`
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <h5 class="text-info">${response.qtdSemana}</h5>
                                <small class="text-muted">Vendas no Período</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h5 class="text-success">R$ ${response.vendasSemana}</h5>
                                <small class="text-muted">Faturamento do Período</small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="progress mb-2">
                        <div class="progress-bar" role="progressbar" style="width: ${response.percentualMeta}%" aria-valuenow="${response.percentualMeta}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted">Meta: R$ ${response.metaSemanal} (${response.percentualMeta}%)</small>
                `);

                // Atualizar status das vendas
                $('#statusVendas').html(`
                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="text-success">${response.percentualConcluidas}%</h5>
                            <small class="text-muted">Concluídas</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-warning">${(100 - parseFloat(response.percentualConcluidas.replace(',', '.'))).toFixed(1)}%</h5>
                            <small class="text-muted">Em Aberto</small>
                        </div>
                    </div>
                    <hr>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-success" style="width: ${response.percentualConcluidas}%"></div>
                        <div class="progress-bar bg-warning" style="width: ${100 - parseFloat(response.percentualConcluidas.replace(',', '.'))}%"></div>
                    </div>
                    <small class="text-muted">Total: ${response.vendasConcluidas + response.vendasAberto} vendas no período</small>
                `);

                // Atualizar top vendedores
                let vendedoresHtml = '';
                if (response.topVendedores && response.topVendedores.length > 0) {
                    response.topVendedores.forEach(function(vendedor, index) {
                        vendedoresHtml += `
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <strong>${vendedor.nome}</strong>
                                    <small class="text-muted d-block">${vendedor.quantidade} vendas</small>
                                </div>
                                <div class="text-right">
                                    <span class="badge badge-primary">R$ ${vendedor.total.toFixed(2).replace('.', ',')}</span>
                                </div>
                            </div>
                            ${index < response.topVendedores.length - 1 ? '<hr>' : ''}
                        `;
                    });
                } else {
                    vendedoresHtml = '<p class="text-muted">Nenhuma venda encontrada no período</p>';
                }
                $('#topVendedores').html(vendedoresHtml);

                // Atualizar top cidades
                let cidadesHtml = '';
                if (response.topCidades && response.topCidades.length > 0) {
                    response.topCidades.forEach(function(cidade, index) {
                        cidadesHtml += `
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <strong>${cidade.cidade}</strong>
                                    <small class="text-muted d-block">${cidade.quantidade} vendas</small>
                                </div>
                                <div class="text-right">
                                    <span class="badge badge-secondary">R$ ${parseFloat(cidade.total).toFixed(2).replace('.', ',')}</span>
                                </div>
                            </div>
                            ${index < response.topCidades.length - 1 ? '<hr>' : ''}
                        `;
                    });
                } else {
                    cidadesHtml = '<p class="text-muted">Nenhuma venda encontrada no período</p>';
                }
                $('#topCidades').html(cidadesHtml);

                // Atualizar resumo executivo
                $('#resumoExecutivo').html(`
                    <div class="row">
                        <div class="col-lg-2 col-md-4 col-6 text-center">
                            <h4 class="text-primary">${response.resumo.totalVendas}</h4>
                            <small class="text-muted">Total de Vendas</small>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 text-center">
                            <h4 class="text-success">R$ ${response.resumo.faturamento}</h4>
                            <small class="text-muted">Faturamento</small>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 text-center">
                            <h4 class="text-info">${response.resumo.estadosAtendidos}</h4>
                            <small class="text-muted">Estados Atendidos</small>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 text-center">
                            <h4 class="text-warning">${response.resumo.cidadesAtendidas}</h4>
                            <small class="text-muted">Cidades Atendidas</small>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 text-center">
                            <h4 class="text-secondary">${response.resumo.vendedoresAtivos}</h4>
                            <small class="text-muted">Vendedores Ativos</small>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 text-center">
                            <h4 class="text-dark">R$ ${response.resumo.mediaDiaria}</h4>
                            <small class="text-muted">Média Diária</small>
                        </div>
                    </div>
                `);

                toastr.success('Filtros aplicados com sucesso!');
            },
            error: function(xhr) {
                toastr.error('Erro ao aplicar filtros. Tente novamente.');
                console.error(xhr);
            }
        });
    });

    // Limpar filtros
    $('#btnLimpar').on('click', function() {
        $('#data_inicio').val('{{ now()->startOfMonth()->format('Y-m-d') }}');
        $('#data_fim').val('{{ now()->format('Y-m-d') }}');
        $('#status_filtro').val('');
        location.reload();
    });
});
</script>
@endpush
