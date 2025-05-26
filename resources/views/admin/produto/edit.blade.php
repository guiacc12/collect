@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Editar Produto</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Painel</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('produto.index') }}">Listar Produtos</a></div>
                <div class="breadcrumb-item">Editar Produto</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Editar Produto</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('produto.update', $produto->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="imagem">Imagem (290x320px)</label>
                                    <input type="file" name="imagem" class="form-control">
                                    @if($produto->imagem)
                                        <img src="{{ asset($produto->imagem) }}" alt="Imagem do Produto" class="img-thumbnail mt-2" style="width: 150px;">
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="titulo">Nome</label>
                                        <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $produto->titulo) }}">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="descricao">Descrição</label>
                                        <textarea name="descricao" class="form-control">{{ old('descricao', $produto->descricao) }}</textarea>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="valor">Valor</label>
                                        <input type="number" name="valor" class="form-control" value="{{ old('valor', $produto->valor) }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="categoria_id">Categoria</label>
                                        <select name="categoria_id" class="form-control">
                                            @foreach($categorias as $categoria)
                                                <option value="{{ $categoria->id }}" {{ $produto->categoria_id == $categoria->id ? 'selected' : '' }}>{{ $categoria->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="promocao_id">Promoção</label>
                                        <select name="promocao_id" id="promocaoSelect" class="form-control">
                                            <option value="">Sem promoção</option>
                                            @foreach($promocaos as $promocao)
                                                <option value="{{ $promocao->id }}" {{ $produto->promocao_id == $promocao->id ? 'selected' : '' }}>{{ $promocao->titulo }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6" id="valorPromocionalField" style="{{ $produto->promocao_id ? 'display: block;' : 'display: none;' }}">
                                        <label for="valor_promocional">Valor Promocional</label>
                                        <input type="number" name="valor_promocional" class="form-control" value="{{ old('valor_promocional', $produto->valor_promocional) }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ $produto->status == 1 ? 'selected' : '' }}>Ativo</option>
                                            <option value="0" {{ $produto->status == 0 ? 'selected' : '' }}>Inativo</option>
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
