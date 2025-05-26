@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detalhes da Venda - {{ $venda->vendedor->nome }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Painel</a></div>
                <div class="breadcrumb-item"><a href="{{ route('vendedor.index') }}">Vendedores</a></div>
                <div class="breadcrumb-item">Detalhes da Venda</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Venda #{{ $venda->id }}</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Produto:</strong> {{ $venda->produto_nome }}</p>
                            <p><strong>Quantidade:</strong> {{ $venda->quantidade }}</p>
                            <p><strong>Valor Total:</strong> R$ {{ number_format($venda->valor_venda, 2, ',', '.') }}</p>
                            <p><strong>Cliente:</strong> {{ $venda->comprador_nome }}</p>
                            <p><strong>CPF/CNPJ:</strong> {{ $venda->cpf_cnpj }}</p>
                            <p><strong>CEP:</strong> {{ $venda->cep }}</p>
                            <p><strong>Rua:</strong> {{ $venda->rua }}</p>
                            <p><strong>Número:</strong> {{ $venda->numero }}</p>
                            <p><strong>Complemento:</strong> {{ $venda->complemento }}</p>
                            <p><strong>Bairro:</strong> {{ $venda->bairro }}</p>
                            <p><strong>Cidade:</strong> {{ $venda->cidade }}</p>
                            <p><strong>Status:</strong><span
                                    id="statusVenda">{{ $venda->status ? 'Concluída' : 'Em progresso' }}</span></p>
                            <p><strong>Data da Venda:</strong> {{ $venda->created_at->format('d/m/Y H:i') }}</p>


                            <div class="ml-auto">
                                <a href="{{ route('vendedor.index') }}" class="btn btn-primary">Voltar</a>
                                @if (!$venda->status)
                                    <button id="btnConcluirVenda" class="btn btn-success" data-id="{{ $venda->id }}">
                                        Concluir Venda
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("btnConcluirVenda")?.addEventListener("click", function() {
                let vendaId = this.dataset.id;

                // Usando SweetAlert para confirmar a ação
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Você deseja concluir esta venda?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, concluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Faz a requisição para concluir a venda
                        fetch(`/admin/vendas/${vendaId}/concluir`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json",
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Atualiza o status na página
                                    document.getElementById("statusVenda").textContent =
                                        "Concluída";
                                    document.getElementById("btnConcluirVenda")
                                .remove(); // Remove o botão

                                    // Exibe uma mensagem de sucesso
                                    Swal.fire(
                                        'Concluído!',
                                        'A venda foi concluída com sucesso.',
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        'Erro!',
                                        'Ocorreu um erro ao concluir a venda.',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                console.error("Erro:", error);
                                Swal.fire(
                                    'Erro!',
                                    'Ocorreu um erro ao concluir a venda.',
                                    'error'
                                );
                            });
                    }
                });
            });
        });
    </script>
@endsection
