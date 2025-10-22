$(document).ready(function() {
    const colaboradorId = window.colaboradorId;

    // Abrir modal para adicionar serviço ao colaborador
    $('#btnAdicionarServicoColaborador').on('click', function() {
        $('#modalAdicionarServicoColaborador').modal('show');
    });

    // Carregar serviços quando o modal é totalmente mostrado
    $('#modalAdicionarServicoColaborador').on('shown.bs.modal', function() {
        $.ajax({
            url: window.routeServicosListar,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': window.csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            success: function(response) {
                const $select = $('#servico_id');
                $select.empty().append('<option value="">Selecione um serviço</option>');

                let servicos = response.data || response;

                if (servicos && Array.isArray(servicos) && servicos.length > 0) {
                    servicos.forEach(function(servico) {
                        $select.append(`<option value="${servico.id}">${servico.nome}</option>`);
                    });
                } else {
                    $select.append('<option value="">Nenhum serviço cadastrado</option>');
                }
            },
            error: function(xhr) {
                toastr.error('Erro ao carregar os serviços.');

                const $select = $('#servico_id');
                $select.empty().append('<option value="">Erro ao carregar serviços</option>');
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
                _token: $('meta[name="csrf-token"]').attr('content'),
                servico_id: servicoId,
                quantidade: quantidade,
                valor: valor,
                data_producao: dataProducao
            },
            success: function(response) {
                $('#modalAdicionarServicoColaborador').modal('hide');
                toastr.success('Serviço adicionado com sucesso!');
                location.reload();
            },
            error: function(xhr) {
                toastr.error('Erro ao adicionar serviço.');
            }
        });
    });

    // Excluir serviço
    $(document).on('click', '.btnExcluirServico', function() {
        const servicoId = $(this).data('id');

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
                    url: `/admin/colaboradores/${colaboradorId}/servicos/${servicoId}`,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        toastr.success('Serviço excluído com sucesso!');
                        location.reload();
                    },
                    error: function(xhr) {
                        toastr.error('Erro ao excluir serviço.');
                    }
                });
            }
        });
    });

    // Buscar serviços por período
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

                if (response.servicos && response.servicos.length > 0) {
                    response.servicos.forEach(function(servico) {
                        $('#servicosTable tbody').append(`
                            <tr>
                                <td>${servico.nome_servico}</td>
                                <td class="text-center">${servico.quantidade}</td>
                                <td class="text-right">R$ ${servico.valor}</td>
                                <td class="text-right">R$ ${servico.valor_total}</td>
                                <td class="text-center">${servico.data_producao}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-danger btnExcluirServico" data-id="${servico.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);

                        const valorNumerico = parseFloat(servico.valor_total.replace('.', '').replace(',', '.'));
                        totalReceber += valorNumerico;
                        totalPecas += parseInt(servico.quantidade);
                    });
                } else {
                    $('#servicosTable tbody').append('<tr><td colspan="6" class="text-center">Nenhum serviço encontrado para o período selecionado</td></tr>');
                }

                $('#totalPecasPeriodo').text(totalPecas);
                $('#totalReceberPeriodo').text(`R$ ${totalReceber.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);
                $('#resumoPeriodo').show();
                $('#btnGerarPDF').prop('disabled', totalPecas === 0);

                toastr.success('Serviços filtrados com sucesso!');
            },
            error: function(xhr) {
                toastr.error('Erro ao filtrar os serviços.');
            }
        });
    });

    // Limpar filtro
    $('#btnLimparFiltro').on('click', function() {
        location.reload();
    });

    // Gerar PDF
    $('#btnGerarPDF').on('click', function() {
        gerarPDFColaborador();
    });

    // Função para gerar PDF
    window.gerarPDFColaborador = function() {
        const colaboradorNome = window.colaboradorNome;
        const dataInicio = $('#start_date').val();
        const dataFim = $('#end_date').val();

        if (!dataInicio || !dataFim) {
            Swal.fire({
                title: 'Atenção!',
                text: 'Por favor, selecione as datas antes de gerar o relatório.',
                icon: 'warning',
                confirmButtonColor: '#007bff'
            });
            return;
        }

        const totalPecas = $('#totalPecasPeriodo').text() || '0';
        const totalReceber = $('#totalReceberPeriodo').text() || 'R$ 0,00';

        // Coleta dados da tabela
        const tbody = document.querySelector('#servicosTable tbody');
        let tabelaHTML = '';

        if (tbody && tbody.children.length > 0) {
            for (let i = 0; i < tbody.children.length; i++) {
                const row = tbody.children[i];
                const cells = row.cells;
                if (cells.length >= 5 && !row.textContent.includes('Nenhum')) {
                    tabelaHTML += '<tr>';
                    tabelaHTML += '<td>' + cells[0].textContent + '</td>';
                    tabelaHTML += '<td style="text-align: center;">' + cells[1].textContent + '</td>';
                    tabelaHTML += '<td style="text-align: right;">' + cells[2].textContent + '</td>';
                    tabelaHTML += '<td style="text-align: right;">' + cells[3].textContent + '</td>';
                    tabelaHTML += '<td style="text-align: center;">' + cells[4].textContent + '</td>';
                    tabelaHTML += '</tr>';
                }
            }
        }

        // Formatar data
        function formatarData(data) {
            if (!data) return '';
            const partes = data.split('-');
            return partes[2] + '/' + partes[1] + '/' + partes[0];
        }

        const agora = new Date();
        const dataAtual = agora.toLocaleDateString('pt-BR');
        const horaAtual = agora.toLocaleTimeString('pt-BR');

        // Construir HTML do PDF
        let html = '<!DOCTYPE html><html><head>';
        html += '<title>Relatório de Produção - ' + colaboradorNome + '</title>';
        html += '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';
        html += '<style>';
        html += 'body { font-family: Arial, sans-serif; font-size: 11pt; line-height: 1.3; margin: 15px; }';
        html += '.company-name { font-size: 2rem; font-weight: bold; color: #2c3e50; margin-bottom: 0; letter-spacing: 2px; }';
        html += '.table { margin-bottom: 1rem; font-size: 10pt; }';
        html += '.table td, .table th { padding: 0.4rem; border: 1px solid #000; vertical-align: middle; }';
        html += '.table thead th { background-color: #f8f9fa; font-weight: bold; text-align: center; }';
        html += 'h3 { font-size: 1.3rem; margin-bottom: 0.5rem; }';
        html += '.text-right { text-align: right; } .text-center { text-align: center; }';
        html += '.summary-box { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 1rem; border-radius: 0.25rem; margin-bottom: 1rem; }';
        html += 'hr { margin: 1rem 0; }';
        html += '</style></head><body>';
        html += '<div class="container-fluid">';
        html += '<div class="d-flex justify-content-between align-items-center mb-4">';
        html += '<div><h1 class="company-name">SUPREMA</h1><p class="mb-0 text-muted">Relatório de Produção</p></div>';
        html += '<div class="text-right">';
        html += '<h3 class="mb-1">Colaborador: ' + colaboradorNome + '</h3>';
        html += '<p class="mb-0"><strong>Período: ' + formatarData(dataInicio) + ' à ' + formatarData(dataFim) + '</strong></p>';
        html += '<p class="mb-0"><small>Gerado em: ' + dataAtual + ' ' + horaAtual + '</small></p>';
        html += '</div></div><hr>';
        html += '<div class="summary-box"><div class="row">';
        html += '<div class="col-6"><strong>Total de Peças Produzidas:</strong> ' + totalPecas + '</div>';
        html += '<div class="col-6 text-right"><strong>Total a Receber:</strong> ' + totalReceber + '</div>';
        html += '</div></div>';
        html += '<h4>Detalhamento dos Serviços</h4>';
        html += '<table class="table table-bordered">';
        html += '<thead><tr><th>Serviço</th><th>Quantidade</th><th>Valor Unitário</th><th>Valor Total</th><th>Data de Produção</th></tr></thead>';
        html += '<tbody>' + (tabelaHTML || '<tr><td colspan="5" class="text-center">Nenhum serviço encontrado para o período selecionado</td></tr>') + '</tbody>';
        html += '</table><hr>';
        html += '<div class="text-center"><small class="text-muted">Relatório gerado automaticamente em ' + dataAtual + ' ' + horaAtual + ' - SUPREMA</small></div>';
        html += '</div></body></html>';

        // Abrir janela de impressão
        const janela = window.open('', '_blank');
        janela.document.write(html);
        janela.document.close();
        janela.onload = function() {
            janela.print();
            janela.close();
        };
    };
});
