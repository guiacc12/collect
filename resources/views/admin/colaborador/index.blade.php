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

    <!-- Modal para detalhes do colaborador -->
    @include('admin.colaborador.modal-detalhes')

    <!-- Modal para adicionar serviço ao colaborador -->
    @include('admin.colaborador.modal-servico-colaborador')

@endsection

<!-- JS -->
@include('admin.colaborador.js')


<style>

    /* Ajuste para a tabela */
    #vendasTable {
        width: 100%;
        white-space: nowrap;
    }
</style>
