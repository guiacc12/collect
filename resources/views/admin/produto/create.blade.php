@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Cadastrar Produto</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Painel</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('produto.index') }}">Listar</a></div>
                <div class="breadcrumb-item">Criar</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Criar Produto</h4>
                            <div class="card-header-action">
                                <a href="{{ route('produto.create') }}" class="btn btn-primary">Ajuda?</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('produto.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Imagem(290x320px)</label>
                                    <input type="file" name="imagem" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">Nome</label>
                                        <input type="text" name="titulo" class="form-control"
                                            placeholder="Adicione um nome" value="{{ old('titulo') }}">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="">Descrição</label>
                                        <textarea name="descricao" class="form-control" placeholder="Adicione uma descrição">{{ old('descricao') }}</textarea>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">Valor</label>
                                        <input type="number" name="valor" class="form-control"
                                            placeholder="Adicione o valor" value="{{ old('valor') }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">Categoria</label>
                                        <select name="categoria_id" class="form-control">
                                            @foreach($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">Promoção</label>
                                        <select name="promocao_id" id="promocaoSelect" class="form-control">
                                            <option value="">Sem promoção</option>
                                            @foreach($promocaos as $promocao)
                                                <option value="{{ $promocao->id }}">{{ $promocao->titulo }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6" id="valorPromocionalField" style="display: none;">
                                        <label for="">Valor Promocional</label>
                                        <input type="number" name="valor_promocional" class="form-control"
                                            placeholder="Adicione o valor promocional" value="{{ old('valor_promocional') }}">
                                    </div>

                                    <div class="form-group col-md-6">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const promocaoSelect = document.getElementById('promocaoSelect');
        const valorPromocionalField = document.getElementById('valorPromocionalField');

        promocaoSelect.addEventListener('change', function () {
            if (this.value) {
                valorPromocionalField.style.display = 'block';
            } else {
                valorPromocionalField.style.display = 'none';
            }
        });
    });
</script>
@endpush
