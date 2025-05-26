@extends('welcome')

@section('content')
<style>
    .preco-original {
        font-size: 1.25rem;
        color: red;
        text-decoration: line-through;
        font-family: 'Poppins', sans-serif;
    }
    .preco-promocional {
        font-size: 1.5rem;
        font-weight: bold;
        color: #000;
        font-family: 'Poppins', sans-serif;
    }
    .preco-normal {
        font-size: 1.5rem;
        font-weight: bold;
        color: #000;
        font-family: 'Poppins', sans-serif;
    }
    .descricao-container {
        margin-top: 1rem;
        padding: 1rem;
        background-color: #ebe3d6;
        color: rgb(0, 0, 0);
        border-radius: 5px;
    }
    .descricao-titulo {
        margin-bottom: 0.5rem;
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
    }
    .descricao-texto {
        text-align: justify;
        line-height: 1.6;
        white-space: pre-line;
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
    }
    .container {
        min-height: 80vh;
        min-width: 80vw;
        border-radius: 5%;
        margin-top: 80px;
    }
    .prod-tit {
        color: #000;
        font-family: 'Poppins', sans-serif;
    }
    .text-end {
        text-align: right;
    }
    .text-center {
        text-align: center;
    }

    .img-fluid {
        border-radius: 3%;
    }
</style>


<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row justify-content-center w-100">
        <div class="col-md-10 p-4 rounded" style="background-color: #f0ebe3;">
            <div class="row">
                <!-- Imagem do Produto -->
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->titulo }}" class="img-fluid w-100">
                </div>
                <!-- Detalhes do Produto -->
                <div class="col-md-6 d-flex flex-column justify-content-start">
                    <h2 class="fw-bold prod-tit mb-2">{{ $produto->titulo }}</h2>
                    <div class="text-end mb-2">
                        @if($produto->valor_promocional)
                            <p class="preco-original">R$ {{ number_format($produto->valor, 2, ',', '.') }}</p>
                            <p class="preco-promocional">R$ {{ number_format($produto->valor_promocional, 2, ',', '.') }}</p>
                        @else
                            <p class="preco-normal">R$ {{ number_format($produto->valor, 2, ',', '.') }}</p>
                        @endif
                    </div>
                    <div class="descricao-container mb-2">
                        <h5 class="descricao-titulo">Descrição</h5>
                        <p class="descricao-texto">{{ $produto->descricao }}</p>
                    </div>
                    <div class="text-center mt-2">
                        <a href="#" class="btn btn-primary">Comprar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
