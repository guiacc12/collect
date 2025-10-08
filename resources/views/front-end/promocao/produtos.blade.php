@extends('welcome')

@section('title', 'Produtos em Promoção - ' . $promocao->titulo)

@section('content')
    <div class="container produtos-container text-center pt-5 h-100 position-relative">
        <div class="promocao-header mb-5">
            <h1 class="promocao-title">{{ $promocao->titulo }}</h1>
            <div class="promocao-divider"></div>
        </div>

        @if($produtos->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="produtos-list">
                @foreach ($produtos as $prod)
                    <div class="col d-flex justify-content-center produto-item" data-id="{{ $prod->id }}">
                        <a href="{{ url('front-end/show/' . $prod->categoria->slug . '/' . $prod->slug) }}"
                           class="text-decoration-none"
                           aria-label="Ver produto {{ $prod->titulo }}">
                            <div class="produto-card" role="button" tabindex="0">
                                <img src="{{ asset($prod->imagem) }}"
                                     alt="Produto {{ $prod->titulo }}"
                                     loading="lazy"
                                     decoding="async">
                                <div class="produto-overlay">
                                    <h3 class="produto-nome">{{ $prod->titulo }}</h3>
                                    <p class="produto-subtitle">Peça exclusiva para transformar seu ambiente</p>
                                    <div class="produto-precos">
                                        @if($prod->valor_promocional)
                                            <p class="preco-original">R$ {{ number_format($prod->valor, 2, ',', '.') }}</p>
                                            <p class="preco-promocional">R$ {{ number_format($prod->valor_promocional, 2, ',', '.') }}</p>
                                        @else
                                            <p class="preco-normal">R$ {{ number_format($prod->valor, 2, ',', '.') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Paginação -->
            @if($produtos->hasPages())
                <div class="pagination-container mt-5">
                    {{ $produtos->links() }}
                </div>
            @endif
        @else
            <div class="no-products-message">
                <div class="empty-state">
                    <i class="fas fa-tag fa-3x mb-3 text-muted"></i>
                    <h3>Nenhum produto encontrado</h3>
                    <p>Esta promoção ainda não possui produtos cadastrados.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Voltar ao Início</a>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Animação do header da promoção
            gsap.from(".promocao-title", {
                opacity: 0,
                y: 30,
                duration: 0.8,
                ease: "power2.out"
            });


            gsap.from(".promocao-divider", {
                scaleX: 0,
                duration: 0.8,
                delay: 0.4,
                ease: "power2.out"
            });

            // Animação dos cards de produtos (mesmo script do produtos/index)
            document.querySelectorAll('.produto-card').forEach(card => {
                const img = card.querySelector('img');
                const overlay = card.querySelector('.produto-overlay');
                const title = card.querySelector('.produto-nome');
                const subtitle = card.querySelector('.produto-subtitle');
                const precos = card.querySelector('.produto-precos');

                gsap.set(subtitle, { opacity: 0, y: 10 });

                const hoverIn = () => {
                    gsap.killTweensOf([img, title, subtitle, precos]);

                    gsap.to(card, {
                        y: -12,
                        rotationX: 2,
                        duration: 0.4,
                        ease: "power2.out"
                    });

                    gsap.to(img, {
                        scale: 1.08,
                        filter: "brightness(0.7) contrast(1.2) saturate(1.1)",
                        duration: 0.4,
                        ease: "power2.out"
                    });

                    gsap.to(title, {
                        y: -4,
                        duration: 0.3,
                        ease: "power2.out"
                    });

                    gsap.to(subtitle, {
                        opacity: 1,
                        y: 0,
                        duration: 0.3,
                        delay: 0.1,
                        ease: "power2.out"
                    });

                    gsap.to(precos, {
                        y: -2,
                        duration: 0.3,
                        delay: 0.05,
                        ease: "power2.out"
                    });
                };

                const hoverOut = () => {
                    gsap.killTweensOf([img, title, subtitle, precos]);

                    gsap.to(card, {
                        y: 0,
                        rotationX: 0,
                        duration: 0.4,
                        ease: "power2.out"
                    });

                    gsap.to(img, {
                        scale: 1,
                        filter: "brightness(0.9) contrast(1.1)",
                        duration: 0.4,
                        ease: "power2.out"
                    });

                    gsap.to(title, {
                        y: 0,
                        duration: 0.3,
                        ease: "power2.out"
                    });

                    gsap.to(subtitle, {
                        opacity: 0,
                        y: 10,
                        duration: 0.2,
                        ease: "power2.out"
                    });

                    gsap.to(precos, {
                        y: 0,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                };

                card.addEventListener('mouseenter', hoverIn);
                card.addEventListener('focus', hoverIn);
                card.addEventListener('mouseleave', hoverOut);
                card.addEventListener('blur', hoverOut);

                gsap.from(card, {
                    opacity: 0,
                    y: 50,
                    duration: 0.6,
                    ease: "power2.out",
                    delay: Math.random() * 0.3,
                    scrollTrigger: {
                        trigger: card,
                        start: "top 85%",
                        toggleActions: "play none none reverse"
                    }
                });
            });

            // Animação do empty state se não houver produtos
            if (document.querySelector('.empty-state')) {
                gsap.from(".empty-state", {
                    opacity: 0,
                    y: 30,
                    duration: 0.8,
                    delay: 0.5,
                    ease: "power2.out"
                });
            }
        });
    </script>
@endsection
