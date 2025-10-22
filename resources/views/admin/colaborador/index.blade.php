@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Todos Colaboradores</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Painel</a></div>
                <div class="breadcrumb-item">Colaboradores</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Colaboradores</h4>

                            <div class="card-header-action">
                                <!-- Botão para adicionar colaborador -->
                                <a href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addColaboradorModal">
                                    <i class="fas fa-plus" style="padding-right: 5px"></i>Novo Colaborador
                                </a>
                                <!-- Botão para adicionar serviço -->
                                <a href="#" class="btn btn-success" data-toggle="modal"
                                    data-target="#addServicoModal">
                                    <i class="fas fa-plus" style="padding-right: 5px"></i>Novo Serviço
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- DataTable de Colaboradores -->
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para adicionar colaborador -->
    @include('admin.colaborador.modal-colaborador')

    <!-- Modal para adicionar serviço -->
    @include('admin.colaborador.modal-servico')

@endsection

@push('css')
<style>
    /* Ajuste para a tabela */
    #colaboradores-table {
        width: 100%;
        white-space: nowrap;
    }
</style>
@endpush

@push('scripts')
    <!-- Scripts do DataTable -->
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).ready(function() {
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

            // Excluir colaborador
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
