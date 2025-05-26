@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Todos Vendedores</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Painel</a></div>
                <div class="breadcrumb-item">Vendedores</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Vendedor</h4>

                            <div class="card-header-action">
                                <a href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addVendedorModal"><i class="fas fa-plus"
                                        style="padding-right: 5px"></i>Novo</a>
                            </div>

                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>



    <!-- Modal -->
    <div class="modal fade" id="addVendedorModal" tabindex="-1" role="dialog" aria-labelledby="addVendedorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVendedorModalLabel">Adicionar Novo Vendedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário para adicionar novo vendedor -->
                    <form action="{{ route('vendedor.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="whatsapp">WhatsApp</label>
                            <input type="url" class="form-control" id="whatsapp" name="whatsapp"
                                placeholder="Link direto WhatsApp" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="editVendedorModal" tabindex="-1" role="dialog" aria-labelledby="editVendedorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVendedorModalLabel">Editar Vendedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Formulário para editar vendedor -->
                    <form id="editVendedorForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit_nome">Nome</label>
                            <input type="text" class="form-control" id="edit_nome" name="nome" placeholder="Nome"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit_telefone">Telefone</label>
                            <input type="text" class="form-control" id="edit_telefone" name="telefone"
                                placeholder="Telefone" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_whatsapp">WhatsApp</label>
                            <input type="url" class="form-control" id="edit_whatsapp" name="whatsapp"
                                placeholder="Link direto WhatsApp" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Vendedor -->
    <div class="modal fade" id="vendasVendedorModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vendas de <span id="vendedorNome"></span></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Período:</label>
                        <input type="date" id="start_date"> até <input type="date" id="end_date">
                        <button class="btn btn-primary" id="buscarVendas">Buscar</button>
                    </div>
                    <p><strong>Peças vendidas:</strong> <span id="totalPecas"></span></p>
                    <p><strong>Valor total vendido:</strong> R$ <span id="totalVendas"></span></p>

                    <div class="table-responsive"> 
                        <table class="table table-striped" id="vendasTable">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Comprador</th>
                                    <th>Quantidade</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}



        <!-- Seu script personalizado -->
        <script>
            $(document).on('click', '.edit-vendedor', function() {
                var vendedorId = $(this).data('id');

                $.ajax({
                    url: '/admin/vendedor/' + vendedorId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        if ($('#edit_nome').length) $('#edit_nome').val(response.nome);
                        if ($('#edit_telefone').length) $('#edit_telefone').val(response.telefone);
                        if ($('#edit_whatsapp').length) $('#edit_whatsapp').val(response.whatsapp);

                        $('#editVendedorForm').attr('action', '/admin/vendedor/' + vendedorId);
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                let vendasTable;

                // Abre o modal e inicializa o DataTable
                $(document).on('click', '.view-vendas', function() {
                    let vendedorId = $(this).data('id');
                    let vendedorNome = $(this).data('nome');

                    $('#vendedorNome').text(vendedorNome);
                    $('#vendasVendedorModal').modal('show');

                    // Inicializa ou recria o DataTable
                    if ($.fn.DataTable.isDataTable('#vendasTable')) {
                        vendasTable.destroy(); // Destrói a instância existente
                    }

                    vendasTable = $('#vendasTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: `/admin/vendas/${vendedorId}/filtrar`,
                            type: 'GET',
                            data: function(d) {
                                d.start_date = $('#start_date').val();
                                d.end_date = $('#end_date').val();
                            }
                        },
                        columns: [{
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
                                className: 'text-left'
                            },
                            {
                                data: 'valor_venda',
                                name: 'valor_venda',
                                className: 'text-left',
                                render: $.fn.dataTable.render.number(',', '.', 2, 'R$ ')
                            },
                            {
                                data: 'status',
                                name: 'status',
                                render: function(data) {
                                    // Define a classe CSS com base no status
                                    let statusClass = data ? 'bg-success' : 'bg-warning';
                                    let statusText = data ? 'Concluído' : 'Em progresso';
                                    return `<span class="badge ${statusClass}">${statusText}</span>`;
                                }
                            },
                            {
                                data: 'id',
                                name: 'id',
                                render: function(data) {
                                    return `<a href="/admin/vendas/${data}/detalhes" class="btn btn-primary btn-sm">Detalhes</a>`;
                                }
                            }
                        ],
                        drawCallback: function(settings) {
                            // Atualiza os totais após carregar os dados
                            let totalPecas = 0;
                            let totalVendas = 0;

                            this.api().data().each(function(venda) {
                                totalPecas += venda.quantidade;
                                totalVendas += parseFloat(venda.valor_venda);
                            });

                            $('#totalPecas').text(totalPecas);
                            $('#totalVendas').text(totalVendas.toLocaleString('pt-BR', {
                                style: 'currency',
                                currency: 'BRL'
                            }));
                        },
                        error: function(xhr, status, error) {
                            console.error("Erro ao carregar vendas:", error);
                        }
                    });
                });

                // Filtra as vendas ao clicar no botão "Buscar"
                $('#buscarVendas').on('click', function() {
                    vendasTable.ajax.reload(); // Recarrega o DataTable com os novos filtros
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.close, .btn-secondary').click(function() {
                    $('.modal').modal('hide'); // Fecha o modal quando o botão "Fechar" for clicado
                });
            });
        </script>
    @endpush
@endsection

<style>
    /* Ajusta o tamanho do modal */
    #vendasVendedorModal .modal-dialog {
        max-width: 90%;
        /* Define um tamanho maior para o modal */
    }

    /* Garante que o corpo do modal role se houver muitos itens */
    #vendasVendedorModal .modal-body {
        max-height: 70vh;
        /* Limita a altura do modal */
        overflow-y: auto;
        /* Adiciona rolagem vertical se necessário */
    }

    /* Ajuste para a tabela */
    #vendasTable {
        width: 100%;
        white-space: nowrap;
    }
</style>
