@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Editar Promoção</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Painel</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('promocao.index') }}">Listar</a></div>
                <div class="breadcrumb-item">Editar</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Editar Promoção</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('promocao.update', $promocao->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Imagem(1300x500px)</label>
                                    <input type="file" name="imagem" class="form-control">
                                    <img src="{{ asset($promocao->imagem) }}" style="width: 100px; height: auto;" class="mt-2">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Nome</label>
                                        <input type="text" name="titulo" class="form-control"
                                            value="{{ $promocao->titulo }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ $promocao->status == 1 ? 'selected' : '' }}>Ativo</option>
                                            <option value="0" {{ $promocao->status == 0 ? 'selected' : '' }}>Inativo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Início da Promoção</label>
                                        <input type="datetime-local" name="inicio" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($promocao->inicio)->format('Y-m-d\TH:i') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Fim da Promoção</label>
                                        <input type="datetime-local" name="fim" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($promocao->fim)->format('Y-m-d\TH:i') }}">
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
