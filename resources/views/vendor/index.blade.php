@extends('vendor.layouts.master')

@section('title', 'Dashboard Vendedor')

@section('content')
<!-- START Main Content -->
<section class="section container">
    <div class="section-header">
        <h1>Bem-vindo, {{ $vendedor->nome }}!</h1>
    </div>

            <!-- Botão Nova Venda -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <button class="btn btn-primary btn-lg" style="font-size: 1.5rem; padding: 15px 40px;"
                                data-toggle="modal" data-target="#novaVendaModal">
                                <i class="fas fa-plus-circle mr-2"></i>
                                NOVA VENDA
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards Informativos -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card card-statistic-1 shadow-sm border-left-primary">
                        <div class="card-icon bg-gradient-primary">
                            <i class="far fa-chart-bar"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary font-weight-bold">Total de Vendas</h4>
                            </div>
                            <div class="card-body">
                                <span class="h2 font-weight-bold text-primary">{{ $totalVendas }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card card-statistic-1 shadow-sm border-left-success">
                        <div class="card-icon bg-gradient-success">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-success font-weight-bold">Valor Total Vendido</h4>
                            </div>
                            <div class="card-body">
                                <span class="h5 font-weight-bold text-success">R$
                                    {{ number_format($valorTotalVendas, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card card-statistic-1 shadow-sm border-left-warning">
                        <div class="card-icon bg-gradient-warning">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-warning font-weight-bold">Taxa de Comissão</h4>
                            </div>
                            <div class="card-body">
                                <span
                                    class="h3 font-weight-bold text-warning">{{ number_format($vendedor->comissao, 1) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card card-statistic-1 shadow-sm border-left-info">
                        <div class="card-icon bg-gradient-info">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-info font-weight-bold">Estado Top</h4>
                            </div>
                            <div class="card-body">
                                <span class="h4 font-weight-bold text-info">{{ $estadoMaisVendeu->estado ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buscador por Data -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-left-primary">
                        <div class="card-header bg-gradient-primary text-white">
                            <h4 class="mb-0"><i class="fas fa-search mr-2"></i>Filtrar Estatísticas por Período
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary">
                                            <i class="fas fa-calendar-alt mr-1"></i>Data Início
                                        </label>
                                        <input type="date" class="form-control border-primary" id="dataInicio"
                                            value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary">
                                            <i class="fas fa-calendar-check mr-1"></i>Data Fim
                                        </label>
                                        <input type="date" class="form-control border-primary" id="dataFim"
                                            value="{{ now()->endOfMonth()->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary">&nbsp;</label>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-lg shadow-sm"
                                                id="buscarPeriodo">
                                                <i class="fas fa-search"></i> Buscar Estatísticas
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-lg ml-2"
                                                id="limparFiltro">
                                                <i class="fas fa-eraser"></i> Limpar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Segunda linha de cards -->
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card card-statistic-1 shadow-sm border-left-warning">
                        <div class="card-icon bg-gradient-warning">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-warning font-weight-bold" id="tituloVendasPeriodo">Vendas -
                                    {{ now()->format('F Y') }}</h4>
                            </div>
                            <div class="card-body">
                                <span class="h2 font-weight-bold text-warning"
                                    id="numeroVendasPeriodo">{{ $vendasMesAtual }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card card-statistic-1 shadow-sm border-left-primary">
                        <div class="card-icon bg-gradient-primary">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary font-weight-bold" id="tituloValorPeriodo">Vendas do Mês -
                                    {{ now()->format('F Y') }}</h4>
                            </div>
                            <div class="card-body">
                                <span class="h5 font-weight-bold text-primary" id="valorVendasPeriodo">R$
                                    {{ number_format($valorVendasMesAtual, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card card-statistic-1 shadow-sm border-left-success">
                        <div class="card-icon bg-gradient-success">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-success font-weight-bold" id="tituloComissaoPeriodo">Comissão do
                                    Mês - {{ now()->format('F Y') }}</h4>
                            </div>
                            <div class="card-body">
                                <span class="h5 font-weight-bold text-success" id="comissaoValorPeriodo">R$
                                    {{ number_format($comissaoMesAtual, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DataTable das Vendas -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-gradient-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0"><i class="fas fa-table mr-2"></i>Minhas Vendas</h4>
                                <span class="badge badge-light">Vendas pendentes aparecem primeiro</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filtros do DataTable -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="card border-left-primary">
                                        <div class="card-body py-3">
                                            <h6 class="text-primary font-weight-bold mb-3">
                                                <i class="fas fa-filter mr-2"></i>Filtros da Tabela
                                            </h6>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group mb-2">
                                                        <label class="small font-weight-bold">Data Início</label>
                                                        <input type="date" class="form-control form-control-sm"
                                                            id="dataInicioTabela">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-2">
                                                        <label class="small font-weight-bold">Data Fim</label>
                                                        <input type="date" class="form-control form-control-sm"
                                                            id="dataFimTabela">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="small font-weight-bold">&nbsp;</label>
                                                        <div>
                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                id="filtrarTabela">
                                                                <i class="fas fa-search"></i> Filtrar Tabela
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-outline-secondary btn-sm ml-2"
                                                                id="limparFiltroTabela">
                                                                <i class="fas fa-times"></i> Limpar Filtros
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="vendasTable">
                                    <thead class="thead">
                                        <tr>
                                            <th><i class="fas fa-calendar mr-1"></i>Data</th>
                                            <th><i class="fas fa-box mr-1"></i>Produto</th>
                                            <th><i class="fas fa-user mr-1"></i>Cliente</th>
                                            <th class="d-none d-lg-table-cell"><i class="fas fa-sort-numeric-up mr-1"></i>Qtd</th>
                                            <th class="d-none d-md-table-cell"><i class="fas fa-dollar-sign mr-1"></i>Valor</th>
                                            <th class="d-none d-lg-table-cell"><i class="fas fa-map-marker-alt mr-1"></i>Estado</th>
                                            <th><i class="fas fa-flag mr-1"></i>Status</th>
                                            <th class="d-none d-md-table-cell"><i class="fas fa-cogs mr-1"></i>Ações</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Nova Venda -->
    <div class="modal fade" id="novaVendaModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nova Venda</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="novaVendaForm" action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome do Produto</label>
                                    <input type="text" class="form-control" name="produto_nome" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome do Comprador</label>
                                    <input type="text" class="form-control" name="comprador_nome" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantidade</label>
                                    <input type="number" class="form-control" name="quantidade" min="1"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Valor da Venda</label>
                                    <input type="number" class="form-control" name="valor_venda" step="0.01"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CPF/CNPJ</label>
                                    <input type="text" class="form-control" name="cpf_cnpj">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CEP</label>
                                    <input type="text" class="form-control" name="cep">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Rua</label>
                                    <input type="text" class="form-control" name="rua">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Número</label>
                                    <input type="text" class="form-control" name="numero">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bairro</label>
                                    <input type="text" class="form-control" name="bairro">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cidade</label>
                                    <input type="text" class="form-control" name="cidade">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <select class="form-control" name="estado">
                                        <option value="">Selecione...</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Complemento</label>
                            <input type="text" class="form-control" name="complemento">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Venda</button>
                    </div>
                </form>
        </div>
    </div>
</section>
<!-- END Main Content -->
@endsection

@push('scripts')
<script>
    let vendasTable;

    $(document).ready(function() {
        // Inicializar DataTable
        vendasTable = $('#vendasTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('vendor.vendas.data') }}',
                data: function(d) {
                    d.data_inicio = $('#dataInicioTabela').val();
                    d.data_fim = $('#dataFimTabela').val();
                }
            },
            columns: [{
                    data: 'data_formatada',
                    name: 'created_at'
                },
                {
                    data: 'produto_nome',
                    name: 'produto_nome'
                },
                {
                    data: 'comprador_nome',
                    name: 'comprador_nome'
                },
                {
                    data: 'quantidade',
                    name: 'quantidade',
                    className: 'd-none d-lg-table-cell'
                },
                {
                    data: 'valor_formatado',
                    name: 'valor_venda',
                    className: 'd-none d-md-table-cell'
                },
                {
                    data: 'estado',
                    name: 'estado',
                    className: 'd-none d-lg-table-cell'
                },
                {
                    data: 'status_badge',
                    name: 'status'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    className: 'd-none d-md-table-cell'
                }
            ],
            order: [
                [6, 'asc'],
                [0, 'desc']
            ], // Ordena por status primeiro, depois por data
            language: {
                processing: "Processando...",
                search: "Buscar:",
                lengthMenu: "Exibir _MENU_ registros por página",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totais)",
                loadingRecords: "Carregando...",
                zeroRecords: "Nenhum registro encontrado",
                emptyTable: "Nenhum dado disponível na tabela",
                paginate: {
                    first: "Primeiro",
                    previous: "Anterior",
                    next: "Próximo",
                    last: "Último"
                },
                aria: {
                    sortAscending: ": ativar para classificar a coluna em ordem crescente",
                    sortDescending: ": ativar para classificar a coluna em ordem decrescente"
                }
            }
        });

        // Limpar formulário quando modal abrir
        $('#novaVendaModal').on('show.bs.modal', function() {
            $('#novaVendaForm')[0].reset();
        });

        // Buscar dados por período (estatísticas)
        $('#buscarPeriodo').on('click', function() {
            buscarDadosPorPeriodo();
        });

        // Limpar filtro e voltar ao mês atual (estatísticas)
        $('#limparFiltro').on('click', function() {
            $('#dataInicio').val('{{ now()->startOfMonth()->format('Y-m-d') }}');
            $('#dataFim').val('{{ now()->endOfMonth()->format('Y-m-d') }}');
            buscarDadosPorPeriodo();
        });

        // Filtrar tabela
        $('#filtrarTabela').on('click', function() {
            filtrarTabela();
        });

        // Limpar filtros da tabela
        $('#limparFiltroTabela').on('click', function() {
            $('#dataInicioTabela').val('');
            $('#dataFimTabela').val('');
            vendasTable.ajax.reload();
        });
    });

    function buscarDadosPorPeriodo() {
        const dataInicio = $('#dataInicio').val();
        const dataFim = $('#dataFim').val();

        if (!dataInicio || !dataFim) {
            Swal.fire({
                title: 'Atenção!',
                text: 'Por favor, selecione as datas de início e fim.',
                icon: 'warning'
            });
            return;
        }

        if (dataInicio > dataFim) {
            Swal.fire({
                title: 'Erro!',
                text: 'A data de início deve ser anterior à data de fim.',
                icon: 'error'
            });
            return;
        }

        // Mostrar loading nos cards
        $('#numeroVendasPeriodo').html('<i class="fas fa-spinner fa-spin"></i>');
        $('#valorVendasPeriodo').html('<i class="fas fa-spinner fa-spin"></i>');
        $('#comissaoValorPeriodo').html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: '{{ route('vendor.stats.periodo') }}',
            type: 'GET',
            data: {
                data_inicio: dataInicio,
                data_fim: dataFim
            },
            success: function(response) {
                // Atualizar títulos dos cards
                $('#tituloVendasPeriodo').text('Vendas - ' + response.periodo_formatado);
                $('#tituloValorPeriodo').text('Valor Vendido - ' + response.periodo_formatado);
                $('#tituloComissaoPeriodo').text('Comissão - ' + response.periodo_formatado);

                // Atualizar valores dos cards
                $('#numeroVendasPeriodo').text(response.vendas_periodo);
                $('#valorVendasPeriodo').text('R$ ' + response.valor_vendas_periodo.toLocaleString(
                    'pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                $('#comissaoValorPeriodo').text('R$ ' + response.comissao_periodo.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            },
            error: function() {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Ocorreu um erro ao buscar os dados.',
                    icon: 'error'
                });

                // Restaurar valores originais em caso de erro
                $('#numeroVendasPeriodo').text('{{ $vendasMesAtual }}');
                $('#valorVendasPeriodo').text('R$ {{ number_format($valorVendasMesAtual, 2, ',', '.') }}');
                $('#comissaoValorPeriodo').text('R$ {{ number_format($comissaoMesAtual, 2, ',', '.') }}');
            }
        });
    }

    function filtrarTabela() {
        const dataInicio = $('#dataInicioTabela').val();
        const dataFim = $('#dataFimTabela').val();

        if (dataInicio && dataFim && dataInicio > dataFim) {
            Swal.fire({
                title: 'Erro!',
                text: 'A data de início deve ser anterior à data de fim.',
                icon: 'error'
            });
            return;
        }

        // Recarregar a tabela com os novos filtros
        vendasTable.ajax.reload();
    }

    function verDetalhes(id) {
        // Implementar visualização de detalhes
        Swal.fire({
            title: 'Detalhes da Venda',
            text: 'Funcionalidade em desenvolvimento...',
            icon: 'info'
        });
    }
</script>
@endpush
