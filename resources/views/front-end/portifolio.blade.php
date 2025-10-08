@extends('welcome')
@section('title')
    SUPREMA
@endsection
@section('content')
    <div class="container catcat text-center mb-4 pt-5 h-100 position-relative">
        <h2 class="my-5">CATEGORIAS</h2>
        <p>Conheaça o nosso trabalho e transformar seus ambientes com peças que são, de fato, feitas para você.</p>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($categorias as $categoria)
                <div class="col d-flex justify-content-center">
                    <a href="{{ url('categoria/' . $categoria->slug) }}"
                       class="text-decoration-none"
                       aria-label="Explorar categoria {{ $categoria->nome }}">
                        <div class="categoria-card" role="button" tabindex="0">
                            <img src="{{ asset($categoria->foto) }}"
                                 alt="Categoria {{ $categoria->nome }}"
                                 loading="lazy"
                                 decoding="async">
                            <div class="categoria-overlay">
                                <h3 class="categoria-nome">{{ $categoria->nome }}</h3>
                                <p class="categoria-subtitle">Descubra nossa coleção exclusiva e transforme seu ambiente.</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.categoria-card').forEach(card => {
                const img = card.querySelector('img');
                const overlay = card.querySelector('.categoria-overlay');
                const title = card.querySelector('.categoria-nome');
                const subtitle = card.querySelector('.categoria-subtitle');

                gsap.set(subtitle, { opacity: 0, y: 10 });

                const hoverIn = () => {
                    gsap.killTweensOf([img, title, subtitle]);

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
                };

                const hoverOut = () => {
                    gsap.killTweensOf([img, title, subtitle]);

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
        });
    </script>
@endsection
