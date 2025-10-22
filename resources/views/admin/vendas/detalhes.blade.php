@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header no-print">
            <h1>Relatório de Venda</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Painel</a></div>
                <div class="breadcrumb-item"><a href="{{ route('vendedor.index') }}">Vendedores</a></div>
                <div class="breadcrumb-item">Detalhes da Venda</div>
            </div>
        </div>

        <div class="section-body">
            <!-- Botões de Ação -->
            <div class="row mb-4 no-print">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Venda #{{ str_pad($venda->id, 6, '0', STR_PAD_LEFT) }}</h5>
                                <div>
                                    <button class="btn btn-danger" onclick="gerarPDF()">
                                        <i class="fas fa-file-pdf mr-2"></i>Gerar PDF
                                    </button>
                                    @if (!$venda->status)
                                        <button id="btnConcluirVenda" class="btn btn-success" data-id="{{ $venda->id }}">
                                            <i class="fas fa-check-circle mr-2"></i>Concluir Venda
                                        </button>
                                    @endif
                                    <a href="{{ route('vendedor.index') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-left mr-2"></i>Voltar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Relatório de Venda -->
            <div id="relatorio-venda">
                <!-- Cabeçalho com Logo -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h1 class="company-name">SUPREMA</h1>
                                <p class="mb-0 text-muted">Sistema de Vendas</p>
                            </div>
                            <div class="text-right">
                                <h3 class="mb-1">Venda #{{ str_pad($venda->id, 6, '0', STR_PAD_LEFT) }}</h3>
                                <p class="mb-0"><strong>{{ $venda->created_at->format('d/m/Y H:i') }}</strong></p>
                                <small class="badge badge-{{ $venda->status ? 'success' : 'warning' }}">
                                    <span id="statusVenda">{{ $venda->status ? 'Concluída' : 'Em Andamento' }}</span>
                                </small>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <!-- Informações Principais em 2 Colunas -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Dados da Venda</h5>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td><strong>Vendedor:</strong></td>
                                <td>{{ $venda->vendedor->nome }}</td>
                            </tr>
                            <tr>
                                <td><strong>Cliente:</strong></td>
                                <td>{{ $venda->comprador_nome }}</td>
                            </tr>
                            @if($venda->cpf_cnpj)
                            <tr>
                                <td><strong>CPF/CNPJ:</strong></td>
                                <td>{{ $venda->cpf_cnpj }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>Valores</h5>
                        <table class="table table-sm table-bordered">
                            <tr class="table-success">
                                <td><strong>VALOR TOTAL:</strong></td>
                                <td><strong>R$ {{ number_format($venda->valor_venda, 2, ',', '.') }}</strong></td>
                            </tr>
                        </table>

                        <h6>Contato Vendedor</h6>
                        <p class="mb-1"><small>{{ $venda->vendedor->email }}</small></p>
                        <p class="mb-0"><small>{{ $venda->vendedor->telefone ?? 'Não informado' }}</small></p>
                    </div>
                </div>

                <!-- Descrição dos Produtos -->
                <div class="row mb-3">
                    <div class="col-12">
                        <h5>Produtos/Serviços</h5>
                        <div class="border p-2" style="min-height: 60px; white-space: pre-line;">{{ $venda->descricao ?? 'Não informado' }}</div>
                    </div>
                </div>

                @if($venda->cep || $venda->rua || $venda->cidade)
                <!-- Endereço Compacto -->
                <div class="row mb-3">
                    <div class="col-12">
                        <h5>Endereço de Entrega</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>{{ $venda->rua ?? 'N/A' }}, {{ $venda->numero ?? 'S/N' }}</strong></p>
                                <p class="mb-0">{{ $venda->bairro ?? 'N/A' }} - {{ $venda->cidade ?? 'N/A' }}/{{ $venda->estado ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>CEP:</strong> {{ $venda->cep ?? 'N/A' }}</p>
                                @if($venda->complemento)
                                <p class="mb-0"><strong>Complemento:</strong> {{ $venda->complemento }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Rodapé Compacto -->
                <div class="row">
                    <div class="col-12 text-center">
                        <hr>
                        <small class="text-muted">Relatório gerado em {{ now()->format('d/m/Y H:i') }} - SUPREMA</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function gerarPDF() {
            // Lista de elementos para esconder durante a impressão
            const elementosParaEsconder = document.querySelectorAll(`
                .no-print,
                .main-sidebar,
                .navbar,
                .main-header,
                .main-footer,
                .sidebar,
                .control-sidebar,
                .breadcrumb,
                .section-header,
                .btn,
                button,
                .card-header,
                nav,
                .pagination
            `);

            // Esconde todos os elementos
            elementosParaEsconder.forEach(el => {
                el.style.display = 'none';
                el.classList.add('hidden-for-print');
            });

            // Ajusta o layout principal temporariamente
            const mainContent = document.querySelector('.main-content');
            const contentWrapper = document.querySelector('.content-wrapper');
            const sectionBody = document.querySelector('.section-body');

            const originalStyles = {
                mainContent: mainContent ? mainContent.style.cssText : '',
                contentWrapper: contentWrapper ? contentWrapper.style.cssText : '',
                sectionBody: sectionBody ? sectionBody.style.cssText : ''
            };

            if (mainContent) {
                mainContent.style.margin = '0';
                mainContent.style.padding = '0';
                mainContent.style.width = '100%';
            }

            if (contentWrapper) {
                contentWrapper.style.margin = '0';
                contentWrapper.style.padding = '0';
                contentWrapper.style.width = '100%';
            }

            if (sectionBody) {
                sectionBody.style.margin = '0';
                sectionBody.style.padding = '15px';
                sectionBody.style.width = '100%';
            }

            // Abre o diálogo de impressão
            window.print();

            // Restaura os elementos após a impressão
            setTimeout(() => {
                elementosParaEsconder.forEach(el => {
                    el.style.display = '';
                    el.classList.remove('hidden-for-print');
                });

                // Restaura estilos originais
                if (mainContent) mainContent.style.cssText = originalStyles.mainContent;
                if (contentWrapper) contentWrapper.style.cssText = originalStyles.contentWrapper;
                if (sectionBody) sectionBody.style.cssText = originalStyles.sectionBody;
            }, 1000);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const btnConcluir = document.getElementById("btnConcluirVenda");
            if (btnConcluir) {
                btnConcluir.addEventListener("click", function() {
                    let vendaId = this.dataset.id;

                    Swal.fire({
                        title: 'Concluir Venda',
                        text: "Tem certeza que deseja marcar esta venda como concluída?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sim, concluir!',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            return fetch('/admin/vendas/' + vendaId + '/concluir', {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    "Content-Type": "application/json",
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (!data.success) {
                                    throw new Error('Erro ao concluir venda');
                                }
                                return data;
                            })
                            .catch(error => {
                                Swal.showValidationMessage('Erro: ' + error.message);
                            });
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Atualiza o status na página
                            document.getElementById("statusVenda").textContent = 'Concluída';
                            document.getElementById("btnConcluirVenda").remove();

                            Swal.fire({
                                title: 'Sucesso!',
                                text: 'A venda foi concluída com sucesso.',
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            });
                        }
                    });
                });
            }
        });
    </script>

    <style>
        .company-name {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 0;
            letter-spacing: 2px;
        }

        .no-print {
            print-color-adjust: exact;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            /* Esconde elementos da interface */
            .main-sidebar,
            .navbar,
            .main-header,
            .main-footer,
            .sidebar,
            .control-sidebar,
            .breadcrumb,
            .section-header,
            .btn,
            button,
            .card-header,
            nav,
            .pagination {
                display: none !important;
            }

            /* Ajusta o layout principal */
            .main-content,
            .content-wrapper,
            .section-body {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            /* Remove margens e paddings desnecessários */
            .container,
            .container-fluid {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }

            body {
                font-size: 11pt;
                line-height: 1.2;
                margin: 0;
                padding: 0;
                background: white !important;
            }

            /* Força o relatório a ocupar toda a página */
            #relatorio-venda {
                margin: 0 !important;
                padding: 15px !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            .company-name {
                font-size: 2rem;
                color: #000 !important;
            }

            .table-sm td {
                padding: 0.2rem 0.4rem;
                font-size: 10pt;
            }

            .table td, .table th {
                padding: 0.3rem;
                border: 1px solid #000 !important;
                font-size: 10pt;
            }

            h3 {
                font-size: 1.3rem;
                margin-bottom: 0.3rem;
            }

            h5 {
                font-size: 1rem;
                margin-bottom: 0.5rem;
                margin-top: 0.8rem;
            }

            h6 {
                font-size: 0.9rem;
                margin-bottom: 0.3rem;
            }

            .mb-3 {
                margin-bottom: 0.8rem !important;
            }

            .mb-1 {
                margin-bottom: 0.2rem !important;
            }

            .border {
                border: 1px solid #000 !important;
            }

            .p-2 {
                padding: 0.3rem !important;
            }

            hr {
                margin: 0.5rem 0;
            }

            .badge {
                color: #000 !important;
                background-color: #f8f9fa !important;
                border: 1px solid #000 !important;
            }

            .page-break {
                page-break-before: always;
            }

            /* Força o conteúdo a caber em uma página */
            #relatorio-venda {
                max-height: 90vh;
                overflow: hidden;
            }
        }
    </style>
@endsection
