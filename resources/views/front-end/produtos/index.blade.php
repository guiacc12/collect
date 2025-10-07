@extends('welcome')

@section('title', 'Produtos - ' . $categorias->nome)

@section('content')
    <style>
        .produto-card {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
            height: 350px;
            width: 300px;
            border: white solid 1px;
            margin: 10px;
        }

        .produto-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out, filter 0.3s ease-in-out;
        }

        .produto-card .produto-nome {
            position: absolute;
            bottom: 0px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
            width: 100%;
            height: 44%;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            align-content: center;
        }

        .produto-card:hover img {
            transform: scale(1.1);
            filter: blur(0.8px);
            filter: brightness(40%);
        }

        .produto-card:hover .produto-nome {
            transform: translate(-50%, -5px);
            opacity: 1;
        }

        .preco-original {
            color: red;
            text-decoration: line-through;
            font-size: 14px;
            margin-right: 5px;
        }

        .preco-promocional {
            font-size: 18px;
            font-weight: bold;
        }

        @media (max-width: 576px) {
            .produto-card {
                width: 280px;
            }
        }

        .produtos-container h2 {
            font-family: 'Poppins', sans-serif;
            color: #fff;
            border-bottom: 1px solid #fff;
            padding-bottom: 10px;
        }

        .produto-nome h5 {
            font-family: 'Poppins', sans-serif;
            color: #fff;
            padding-bottom: 5%;
        }
    </style>

    <div class="container produtos-container text-center pt-5 h-100 position-relative">
        <h2 class="mt-5">{{ $categorias->nome }}</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="produtos-list">
            @foreach ($produtos as $prod)
                <div class="col d-flex justify-content-center produto-item" data-id="{{ $prod->id }}">
                    <a href="{{ url('front-end/show/' . $categorias->slug . '/' . $prod->slug) }}" class="text-decoration-none">
                        <div class="produto-card">
                            <img src="{{ asset($prod->imagem) }}" alt="{{ $prod->titulo }}">
                            <div class="produto-nome">
                                <h5>{{ $prod->titulo }}</h5>
                                @if($prod->valor_promocional)
                                    <p class="preco-original">R$ {{ number_format($prod->valor, 2, ',', '.') }}</p>
                                    <p class="preco-promocional">R$ {{ number_format($prod->valor_promocional, 2, ',', '.') }}</p>
                                @else
                                    <p class="fw-bold">R$ {{ number_format($prod->valor, 2, ',', '.') }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Apenas as animações dos cards permanecem
            document.querySelectorAll('.produto-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    gsap.to(card.querySelector('img'), {
                        scale: 1.1,
                        duration: 0.3,
                        ease: "power1.out"
                    });
                    gsap.to(card.querySelector('.produto-nome'), {
                        y: -5,
                        duration: 0.3,
                        ease: "power1.out"
                    });
                });
                card.addEventListener('mouseleave', () => {
                    gsap.to(card.querySelector('img'), {
                        scale: 1,
                        duration: 0.3,
                        ease: "power1.out"
                    });
                    gsap.to(card.querySelector('.produto-nome'), {
                        y: 0,
                        duration: 0.3,
                        ease: "power1.out"
                    });
                });
            });
        });
    </script>
@endsection
