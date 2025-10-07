@extends('welcome')
@section('title')
    SUPREMA
@endsection
@section('content')
    <style>
        .categoria-card {
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

        .categoria-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out, filter 0.3s ease-in-out;
        }

        .categoria-card .categoria-nome {
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
            font-family: 'Poppins', sans-serif;
        }

        .categoria-card:hover img {
            transform: scale(1.1);
            filter: blur(0.8px);
            filter: brightness(40%);
        }

        .categoria-card:hover .categoria-nome {
            transform: translate(-50%, -5px);
            opacity: 1;
        }

        @media (max-width: 576px) {
            .categoria-card {
                width: 280px;
                /* Largura um pouco menor para mobile */
            }
        }

        .catcat h2 {
            font-family: 'Poppins', sans-serif;
            color: #fff;
            border-bottom: 1px solid #fff;
            padding-bottom: 10px;
        }

        .catcat p {
            font-family: 'Poppins', sans-serif;
            color: #fff;
            font-size: 16px;
        }
    </style>


    <div class="container catcat text-center pt-5 h-100 position-relative">
        <h2 class="my-5">CATEGORIAS</h2>
        <p>Conheaça o nosso trabalho e transformar seus ambientes com peças que são, de fato, feitas para você.</p>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($categorias as $categoria)
                <div class="col d-flex justify-content-center">
                    <a href="{{ url('categoria/' . $categoria->slug) }}" class="text-decoration-none">
                        <div class="categoria-card">
                            <img src="{{ asset($categoria->foto) }}" alt="{{ $categoria->nome }}">
                            <div class="categoria-nome">{{ $categoria->nome }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.categoria-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    gsap.to(card.querySelector('img'), {
                        scale: 1.1,
                        duration: 0.3,
                        ease: "power1.out"
                    });
                    gsap.to(card.querySelector('.categoria-nome'), {
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
                    gsap.to(card.querySelector('.categoria-nome'), {
                        y: 0,
                        duration: 0.3,
                        ease: "power1.out"
                    });
                });
            });
        });
    </script>
@endsection
