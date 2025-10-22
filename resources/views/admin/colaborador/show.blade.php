@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detalhes do Colaborador</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Painel</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.colaboradores.index') }}">Colaboradores</a></div>
                <div class="breadcrumb-item">{{ $colaborador->nome }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $colaborador->nome }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.colaboradores.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Informações do Colaborador -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title">Informações Pessoais</h5>
                                            <p><strong>Nome:</strong> {{ $colaborador->nome }}</p>
                                            <p><strong>Telefone:</strong> {{ $colaborador->telefone ?? 'Não informado' }}</p>
                                            <p><strong>Data de Cadastro:</strong> {{ $colaborador->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Filtros -->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Filtrar Serviços por Período</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="start_date">Data Início:</label>
                                            <input type="date" id="start_date" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="end_date">Data Fim:</label>
                                            <input type="date" id="end_date" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>&nbsp;</label>
                                            <div class="d-flex">
                                                <button id="btnBuscarServicos" class="btn btn-primary me-2">
                                                    <i class="fas fa-search"></i> Buscar
                                                </button>
                                                <button id="btnLimparFiltro" class="btn btn-secondary me-2">
                                                    <i class="fas fa-eraser"></i> Limpar
                                                </button>
                                                <button id="btnGerarPDF" class="btn btn-danger" disabled>
                                                    <i class="fas fa-file-pdf"></i> Gerar PDF
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Resumo do Período -->
                            <div class="card" id="resumoPeriodo" style="display: none;">
                                <div class="card-body bg-info text-white">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Total de Peças no Período:</strong> <span id="totalPecasPeriodo">0</span>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <strong>Total a Receber no Período:</strong> <span id="totalReceberPeriodo">R$ 0,00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botão para Adicionar Serviço -->
                            <div class="mb-3">
                                <button id="btnAdicionarServicoColaborador" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Adicionar Serviço
                                </button>
                            </div>

                            <!-- Tabela de Serviços -->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Serviços Produzidos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="servicosTable">
                                            <thead>
                                                <tr>
                                                    <th>Serviço</th>
                                                    <th class="text-center">Quantidade</th>
                                                    <th class="text-right">Valor Unitário</th>
                                                    <th class="text-right">Valor Total</th>
                                                    <th class="text-center">Data de Produção</th>
                                                    <th class="text-center">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($colaborador->colaboradorServicos as $colaboradorServico)
                                                    <tr>
                                                        <td>{{ $colaboradorServico->servico->nome }}</td>
                                                        <td class="text-center">{{ $colaboradorServico->quantidade }}</td>
                                                        <td class="text-right">R$ {{ number_format($colaboradorServico->valor, 2, ',', '.') }}</td>
                                                        <td class="text-right">R$ {{ number_format($colaboradorServico->valor_total, 2, ',', '.') }}</td>
                                                        <td class="text-center">{{ \Carbon\Carbon::parse($colaboradorServico->data_producao)->format('d/m/Y') }}</td>
                                                        <td class="text-center">
                                                            <button class="btn btn-sm btn-danger btnExcluirServico"
                                                                data-id="{{ $colaboradorServico->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">Nenhum serviço encontrado</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para adicionar serviço ao colaborador -->
    @include('admin.colaborador.modal-servico-colaborador')

@endsection

@push('scripts')
<script>
    // Definir variáveis globais para o JavaScript externo
    window.colaboradorId = {{ $colaborador->id }};
    window.colaboradorNome = '{{ $colaborador->nome }}';
    window.csrfToken = '{{ csrf_token() }}';
    window.routeServicosListar = '{{ route('admin.servicos.listar') }}';
</script>
<script src="{{ asset('backend/assets/js/colaborador-show.js') }}"></script>
@endpush
