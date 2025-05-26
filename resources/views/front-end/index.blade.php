@extends('welcome')
@section('title')
    SUPREMA
@endsection



@section('content')
    <style>
        .mask {
            mask-image: url("{{ asset('backend/assets/img/news/suprema.svg') }}");
            mask-repeat: no-repeat;
            mask-position: center;
            mask-size: contain;
            position: relative;
            height: 100vh;
        }
    </style>
    <div class="main">
        <div class="container-fluid p-4 banner">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($itens as $index => $item)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}"
                            class="{{ $index == 0 ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($itens as $index => $item)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            @php
                                $imagePath = isset($item->banner) ? $item->banner : $item->imagem;
                            @endphp
                            <img class="d-block w-100" src="{{ asset($imagePath) }}"
                                alt="{{ $item->titulo ?? 'Promoção' }}">
                        </div>
                    @endforeach
                </div>

                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="full container-fluid banner2">
            <div class="mask w-100 p-2">
                <img src="{{ asset('backend/assets/img/news/bannergsap.svg') }}" alt="Banner Produtos">
            </div>
            <div class="mask-text px-1">
                <h1 class="textEfeito">Conheça nossos</h1>
                <h1 class="textEfeito">produtos</h1>
                <p class="textEfeito">Criamos móveis que fazem a diferença, que inspiram e</p>
                <p class="textEfeito">que proporcionam a sensação de bem-estar, seja no</p>
                <p class="textEfeito">simples cotidiano ou em momentos especiais.</p>
            </div>
        </div>


        <div class="svg-container">
            <img src="/backend/assets/img/news/group18.svg" alt="Divisor SVG" class="svg-full-width" />
        </div>



        <div class="section-container-fluid carouselProduto">
            <div class="container p-4">
                <div class="progress-container">
                    <h2 class="title" style="color:#252424"><span style="color: #b38e5d">MAIS</span> VENDIDOS</h2>
                </div>
                <div id="customProductCarousel" class="custom-carousel-container">
                    <div class="controls-container">
                        <div class="progress-track">
                            <div class="progress-line" id="line"></div>
                        </div>
                        <div class="custom-carousel-controls">
                            <div class="custom-carousel-control" id="customPrevBtn">
                                <span>❮</span>
                            </div>
                            <div class="custom-carousel-control" id="customNextBtn">
                                <span>❯</span>
                            </div>
                        </div>
                    </div>
                    <div class="custom-carousel-inner">
                        @foreach ($produtosSelecionados as $produto)
                            <div class="custom-carousel-item">
                                <a href="{{ url('front-end/show/' . $produto->categoria->slug . '/' . $produto->slug) }}"
                                    style="text-decoration: none">
                                    <div class="card p-2"
                                        style="width: 290px; height: 440px; background: #ebe3d6; overflow: hidden; display: flex; flex-direction: column;">
                                        <div class="card-body"
                                            style="padding: 15px; color: #000; text-align: left; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                            <h4 class="card-title"
                                                style="font-size: 20px; font-weight: bold; margin-bottom: 5px;">
                                                {{ $produto->titulo }}
                                            </h4>

                                            <div style="width: 100%; height: 320px; overflow: hidden;">
                                                <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->titulo }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div>
                                                @if ($produto->promocao_id && $produto->valor_promocional)
                                                    <p class="text-danger"
                                                        style="font-size: 14px; margin-bottom: 5px; text-align: right">
                                                        <s>de R$ {{ number_format($produto->valor, 2, ',', '.') }}</s>
                                                    </p>
                                                    <p class="font-weight-bold" style="font-size: 16px; text-align: right">
                                                        Por R$
                                                        {{ number_format($produto->valor_promocional, 2, ',', '.') }}
                                                    </p>
                                                @else
                                                    <p class="font-weight-bold" style="font-size: 16px; text-align: right;">
                                                        R$ {{ number_format($produto->valor, 2, ',', '.') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>



        <div class="timeline-section p-4 ">
            <h2 class="timeline-title tituloQuemSomosM">Quem Somos</h2>
            <div class="video-container">
                <video autoplay muted loop playsinline>
                    <source src="{{ asset('backend/assets/img/news/videoLoja.mp4') }}" type="video/mp4">
                </video>
            </div>

            <div class="timeline-content">
                <div class="timeline-progress-track">
                    <div class="timeline-progress-bar"></div>
                </div>
                <h2 class="timeline-title tituloQuemSomos">Quem somos</h2>
                <div class="timeline-items">
                    <div class="timeline-item">
                        <div class="timeline-left">
                            <h2 class="timeline-title">O Início</h2>
                        </div>
                        <div class="timeline-dot-container">
                            <div class="timeline-dot"></div>
                        </div>
                        <div class="timeline-right">
                            <p class="timeline-text">A Suprema Home and Garden foi fundada em 2022 com o propósito de criar
                                móveis que unem funcionalidade, beleza e conforto, proporcionando bem-estar e inspiração.
                            </p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-left">
                            <h2 class="timeline-title">Inovação</h2>
                        </div>
                        <div class="timeline-dot-container">
                            <div class="timeline-dot"></div>
                        </div>
                        <div class="timeline-right">
                            <p class="timeline-text">Superando o convencional, produzimos móveis exclusivos que aliam
                                estética
                                à
                                praticidade, refletindo a personalidade de quem os utiliza</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-left">
                            <h2 class="timeline-title">Missão</h2>
                        </div>
                        <div class="timeline-dot-container">
                            <div class="timeline-dot"></div>
                        </div>
                        <div class="timeline-right">
                            <p class="timeline-text">Nossa missão é oferecer conforto e estilo por meio de produtos
                                duráveis,
                                de
                                alta qualidade e com design inovador.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-left">
                            <h2 class="timeline-title">Compromisso</h2>
                        </div>
                        <div class="timeline-dot-container">
                            <div class="timeline-dot"></div>
                        </div>
                        <div class="timeline-right">
                            <p class="timeline-text">Nosso compromisso transcende a produção de móveis; criamos peças que
                                enriquecem o dia a dia e celebram momentos únicos, com excelência e respeito pela arte de
                                fabricar para toda a vida.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
