@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Cadastrar Promoção</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Painel</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('promocao.index') }}">Listar</a></div>
                <div class="breadcrumb-item">Criar</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Criar Promoção</h4>
                            <div class="card-header-action">
                                <a href="{{ route('promocao.create') }}" class="btn btn-primary">Ajuda?</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('promocao.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Imagem(1300x500px)</label>
                                    <input type="file" name="imagem" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">Nome</label>
                                        <input type="text" name="titulo" class="form-control"
                                            placeholder="Adicione um nome" value="{{ old('titulo') }}">
                                    </div>


                                        <div class="form-group col-md-4">
                                            <label for="">Início da Promoção</label>
                                            <input type="datetime-local" name="inicio" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Fim da Promoção</label>
                                            <input type="datetime-local" name="fim" class="form-control">
                                        </div>


                                    <div class="form-group col-md-4">
                                        <label for="">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1">Ativo</option>
                                            <option value="0">Inativo</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
