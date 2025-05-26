@push('scripts')
    <!-- Scripts do DataTable -->
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).ready(function() {
            let colaboradorId;
            // Abrir modal para adicionar colaborador
            $('#btnAdicionarColaborador').on('click', function() {
                $('#addColaboradorModal').modal('show');
            });

            // Abrir modal para adicionar serviço
            $('#btnAdicionarServico').on('click', function() {
                $('#addServicoModal').modal('show');
            });

            // Salvar colaborador
            $('#btnSalvarColaborador').on('click', function() {
                const formData = $('#formColaborador').serialize();
                $.ajax({
                    url: '{{ route('admin.colaboradores.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addColaboradorModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Colaborador adicionado com sucesso.',
                            confirmButtonText: 'OK'
                        });
                        $('#colaboradores-table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Ocorreu um erro ao adicionar o colaborador.',
                            confirmButtonText: 'OK'
                        });
                        console.error(xhr.responseText);
                    }
                });
            });

            // Salvar serviço
            $('#btnSalvarServico').on('click', function() {
                const formData = $('#formServico').serialize();
                $.ajax({
                    url: '{{ route('admin.servicos.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addServicoModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Serviço adicionado com sucesso.',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Ocorreu um erro ao adicionar o serviço.',
                            confirmButtonText: 'OK'
                        });
                        console.error(xhr.responseText);
                    }
                });
            });

            // Abrir modal de detalhes do colaborador
            $(document).on('click', '.btnDetalhes', function() {
                colaboradorId = $(this).data('id');
                $('#start_date').val('');
                $('#end_date').val('');
                $('#servicosTable tbody').empty();
                $('#totalPecas').text('0');
                $('#totalReceber').text('R$ 0,00');
                $('#modalDetalhes').modal('show');
            });

            // Botão para buscar serviços com filtro de data
            $('#btnBuscarServicos').on('click', function() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();
                if (!startDate || !endDate) {
                    toastr.warning('Preencha as datas de início e fim.');
                    return;
                }
                $.ajax({
                    url: `/admin/colaboradores/${colaboradorId}/detalhes`,
                    type: 'GET',
                    data: {
                        data_inicio: startDate,
                        data_fim: endDate
                    },
                    success: function(response) {
                        $('#servicosTable tbody').empty();
                        let totalPecas = 0;
                        let totalReceber = 0;
                        response.servicos.forEach(function(servico) {
                            $('#servicosTable tbody').append(
                                `<tr>
                             <td>${servico.nome_servico}</td>
                            <td>${servico.quantidade}</td>
                            <td>R$ ${servico.valor}</td>
                            <td>R$ ${servico.valor_total}</td>
                            <td>${servico.data_producao}</td>
                            </tr>`
                            );
                            const valorNumerico = parseFloat(servico.valor_total.replace('.',
                                '').replace(',', '.'));

                            totalReceber += valorNumerico;
                            totalPecas += parseInt(servico.quantidade);
                        });
                        $('#totalPecas').text(totalPecas);
                        $('#totalReceber').text(
                            `R$ ${totalReceber.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`
                        );
                        toastr.success('Serviços filtrados com sucesso!');
                    },
                    error: function(xhr) {
                        toastr.error('Erro ao filtrar os serviços.');
                        console.error(xhr.responseText);
                    }
                });
            });

            // Abrir modal para adicionar serviço ao colaborador
            $('#btnAdicionarServicoColaborador').on('click', function() {
                $('#modalAdicionarServicoColaborador').modal('show');
                $.ajax({
                    url: '{{ route('admin.servicos.listar') }}',
                    type: 'GET',
                    success: function(response) {
                        $('#servico_id').empty().append(
                            '<option value="">Selecione um serviço</option>');
                        response.forEach(function(servico) {
                            $('#servico_id').append(
                                `<option value="${servico.id}">${servico.nome}</option>`
                            );
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Erro ao carregar os serviços.');
                    }
                });
            });

            // Salvar serviço vinculado ao colaborador
            $('#btnSalvarServicoColaborador').on('click', function() {
                const servicoId = $('#servico_id').val();
                const quantidade = $('#quantidade').val();
                const valor = $('#valor').val();
                const dataProducao = $('#data_producao').val();
                if (!servicoId || !quantidade || !valor || !dataProducao) {
                    toastr.warning('Preencha todos os campos obrigatórios.');
                    return;
                }
                $.ajax({
                    url: `/admin/colaboradores/${colaboradorId}/servicos`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        servico_id: servicoId,
                        quantidade: quantidade,
                        valor: valor,
                        data_producao: dataProducao
                    },
                    success: function(response) {
                        $('#modalAdicionarServicoColaborador').modal('hide');
                        toastr.success('Serviço adicionado com sucesso!');
                        $('#servicosTable').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        toastr.error('Erro ao adicionar serviço.');
                        console.error(xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.btnExcluirColaborador', function() {
                const colaboradorId = $(this).data('id');
                Swal.fire({
                    title: 'Tem certeza?',
                    text: 'Você não poderá reverter isso!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/colaboradores/${colaboradorId}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $('#colaboradores-table').DataTable().ajax.reload();
                                toastr.success('Colaborador excluído com sucesso!');
                            },
                            error: function(xhr) {
                                toastr.error('Erro ao excluir colaborador.');
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
