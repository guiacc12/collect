@extends('welcome')

@section('content')
<style>
    .product-container {
        min-height: 80vh;
        margin-top: 80px;
        padding: 2rem 0;
    }

    .product-card {
        background: linear-gradient(135deg, #f0ebe3 0%, #e8ddd0 50%, #f0ebe3 100%);
        border-radius: 20px;
        box-shadow:
            0 20px 40px rgba(0, 0, 0, 0.1),
            0 0 0 1px rgba(255, 255, 255, 0.2);
        padding: 3rem;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(179, 142, 93, 0.05) 0%, transparent 50%);
        pointer-events: none;
    }

    .product-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .product-image-container:hover {
        transform: translateY(-5px);
    }

    .product-image {
        width: 100%;
        height: auto;
        border-radius: 15px;
        transition: transform 0.3s ease;
    }

    .product-image:hover {
        transform: scale(1.05);
    }

    .product-details {
        position: relative;
        z-index: 2;
    }

    .product-title {
        color: #2c2c2c;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        font-weight: 600;
        margin-bottom: 1.5rem;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .price-container {
        background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
    }

    .price-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, #b38e5d, #d4af37, #b38e5d);
    }

    .preco-original {
        font-size: 1.1rem;
        color: #ff6b6b;
        text-decoration: line-through;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 0.5rem;
        opacity: 0.8;
    }

    .preco-promocional {
        font-size: 2rem;
        font-weight: 700;
        color: #4ecdc4;
        font-family: 'Poppins', sans-serif;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        margin: 0;
    }

    .preco-normal {
        font-size: 2rem;
        font-weight: 700;
        color: #4ecdc4;
        font-family: 'Poppins', sans-serif;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        margin: 0;
    }

    .descricao-container {
        background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%);
        border: 1px solid rgba(179, 142, 93, 0.2);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow:
            0 10px 25px rgba(0, 0, 0, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.6);
        position: relative;
    }

    .descricao-titulo {
        color: #2c2c2c;
        font-family: 'Poppins', sans-serif;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .descricao-titulo::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #b38e5d, #d4af37);
        border-radius: 2px;
    }

    .descricao-texto {
        color: #4a4a4a;
        text-align: justify;
        line-height: 1.8;
        white-space: pre-line;
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        font-weight: 300;
    }

    .btn-comprar {
        background: linear-gradient(135deg, #b38e5d 0%, #d4af37 50%, #b38e5d 100%);
        border: none;
        color: white;
        padding: 1rem 3rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow:
            0 10px 20px rgba(179, 142, 93, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.1);
        font-family: 'Poppins', sans-serif;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        overflow: hidden;
    }

    .btn-comprar::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-comprar:hover {
        transform: translateY(-3px);
        box-shadow:
            0 15px 30px rgba(179, 142, 93, 0.4),
            0 0 0 1px rgba(255, 255, 255, 0.2);
        background: linear-gradient(135deg, #d4af37 0%, #b38e5d 50%, #d4af37 100%);
    }

    .btn-comprar:hover::before {
        left: 100%;
    }

    .btn-comprar:active {
        transform: translateY(-1px);
    }

    /* Animações de entrada */
    .product-card {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .product-container {
            margin-top: 60px;
            padding: 1rem;
        }

        .product-card {
            padding: 2rem 1.5rem;
            border-radius: 15px;
        }

        .product-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .price-container {
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .preco-promocional,
        .preco-normal {
            font-size: 1.5rem;
        }

        .descricao-container {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .btn-comprar {
            padding: 0.8rem 2rem;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .product-card {
            padding: 1.5rem 1rem;
        }

        .product-title {
            font-size: 1.5rem;
        }

        .descricao-container {
            padding: 1rem;
        }
    }
</style>

<div class="product-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
                <div class="product-card">
                    <div class="row align-items-center">
                        <!-- Imagem do Produto -->
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="product-image-container">
                                <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->titulo }}" class="product-image">
                            </div>
                        </div>

                        <!-- Detalhes do Produto -->
                        <div class="col-md-6">
                            <div class="product-details">
                                <h1 class="product-title">{{ $produto->titulo }}</h1>

                                <div class="price-container text-center">
                                    @if($produto->valor_promocional)
                                        <p class="preco-original">R$ {{ number_format($produto->valor, 2, ',', '.') }}</p>
                                        <p class="preco-promocional">R$ {{ number_format($produto->valor_promocional, 2, ',', '.') }}</p>
                                    @else
                                        <p class="preco-normal">R$ {{ number_format($produto->valor, 2, ',', '.') }}</p>
                                    @endif
                                </div>

                                <div class="descricao-container">
                                    <h3 class="descricao-titulo">Descrição</h3>
                                    <p class="descricao-texto">{{ $produto->descricao }}</p>
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-comprar">
                                        <i class="fas fa-shopping-cart me-2"></i>
                                        Comprar Agora
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
