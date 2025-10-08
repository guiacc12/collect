<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>SUPREMA</title>



    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/frontend-style.css') }}">
</head>



<body>

    <!-- Inclui o Navbar -->
    @include('layouts.inc.frontNavBar')


    <!-- Conteúdo Principal -->



    <div id="app">
        @yield('content')
    </div>


    <!-- Footer -->

    @include('layouts.inc.frontFooter')



    <!-- General JS Scripts -->
    <script src="{{ asset('backend/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/popper.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/stisla.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>

    <!-- GSAP SCROLLTRIGGER - apenas carregado se necessário -->
    @if(request()->is('/') || request()->is('home'))
    <script src="https://codepen.io/GreenSock/pen/vYqpyLg.js"></script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js"></script>


    <script>
        // Scripts específicos para páginas que têm elementos de mask/hero
        document.addEventListener('DOMContentLoaded', function() {
            const hasMaskElements = document.querySelector('.mask') && document.querySelector('.full');

            if (hasMaskElements) {
                gsap.registerPlugin(ScrollTrigger);

                let valorMaskSize = "3000vw"
                if (window.innerWidth < 1000) {
                    valorMaskSize = "7000vw"
                }
                gsap.to(".mask", {
                    maskSize: valorMaskSize,
                    maskPosition: "50.3% center",
                    scrollTrigger: {
                        trigger: ".full",
                        pin: true,
                        scrub: 0,
                        start: "top top",
                        end: "bottom 20%",
                    }
                })
                gsap.from(".textEfeito", {
                    opacity: 0,
                    y: 80,
                    stagger: .4,
                    scrollTrigger: {
                        trigger: ".mask-text",
                        scrub: 1,
                        start: "top top",
                        end: "bottom 5%",
                    }
                })

                function adjustMaskSize() {
                    const mask = document.querySelector('.mask');
                    if (!mask) return;

                    const windowWidth = window.innerWidth;
                    if (windowWidth >= 1600) {
                        mask.style.maskSize = '80%';
                    } else if (windowWidth >= 1200) {
                        mask.style.maskSize = '90%';
                    } else if (windowWidth >= 992) {
                        mask.style.maskSize = '100%';
                    } else if (windowWidth >= 768) {
                        mask.style.maskSize = '110%';
                    } else if (windowWidth >= 576) {
                        mask.style.maskSize = '130%';
                    } else {
                        mask.style.maskSize = '90%';
                    }
                }
                adjustMaskSize();
                window.addEventListener('resize', adjustMaskSize);
            }
        });


        // Scripts específicos para timeline
        document.addEventListener('DOMContentLoaded', function() {
            const timelineSection = document.querySelector('.timeline-section');

            if (timelineSection) {
                const progressBar = document.querySelector('.timeline-progress-bar');
                const timelineItems = document.querySelectorAll('.timeline-item');
                const timelineTrack = document.querySelector('.timeline-progress-track');

                let isSectionActive = false;

                function updateActiveItems() {
                    const progressBarBottom = progressBar.getBoundingClientRect().bottom;
                    const trackTop = timelineTrack.getBoundingClientRect().top;
                    const trackHeight = timelineTrack.offsetHeight;
                    const progressPercent = (progressBarBottom - trackTop) / trackHeight * 100;

                    timelineItems.forEach(item => {
                        const itemRect = item.getBoundingClientRect();
                        const itemPosition = ((itemRect.top + itemRect.height / 2 - trackTop) / trackHeight) *
                            100;

                        if (itemPosition < progressPercent + 10) {
                            item.classList.add('active');
                        } else {
                            item.classList.remove('active');
                        }
                    });
                }

                const sectionObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        isSectionActive = entry.isIntersecting;

                        if (!entry.isIntersecting) {
                            progressBar.style.height = '0';
                            timelineItems.forEach(item => {
                                item.classList.remove('active');
                            });
                        }
                    });
                }, {
                    threshold: 0.1
                });

                sectionObserver.observe(timelineSection);

                function animateProgressBar() {
                    if (!isSectionActive) return;
                    const sectionRect = timelineSection.getBoundingClientRect();
                    const sectionTop = sectionRect.top + window.scrollY;
                    const sectionHeight = sectionRect.height;
                    const scrollPosition = window.scrollY;
                    const scrollStart = sectionTop;
                    const scrollEnd = sectionTop + sectionHeight - window.innerHeight;

                    let progress = 0;

                    if (scrollPosition >= scrollStart && scrollPosition <= scrollEnd) {
                        progress = ((scrollPosition - scrollStart) / (scrollEnd - scrollStart)) * 100;
                    } else if (scrollPosition > scrollEnd) {
                        progress = 100;
                    }
                    progressBar.style.height = `${progress}%`;
                    updateActiveItems();
                    requestAnimationFrame(animateProgressBar);
                }


                function startAnimation() {
                    if (isSectionActive) {
                        animateProgressBar();
                    }
                }

                window.addEventListener('scroll', startAnimation);
                window.addEventListener('resize', startAnimation);

                startAnimation();
            }
        });

        // Scripts específicos para carousel
        document.addEventListener("DOMContentLoaded", function() {
            const line = document.getElementById("line");
            const items = document.querySelectorAll(".custom-carousel-item");
            const innerCarousel = document.querySelector(".custom-carousel-inner");
            const prevBtn = document.getElementById("customPrevBtn");
            const nextBtn = document.getElementById("customNextBtn");

            // Só executa se os elementos do carousel existirem
            if (!line || !items.length || !innerCarousel || !prevBtn || !nextBtn) {
                return;
            }

            let index = 0;
            let itemsPerView = getItemsPerView();
            const totalItems = items.length;

            let isDragging = false;
            let startPos = 0;
            let startTransformValue = 0;

            function getItemsPerView() {
                if (window.innerWidth <= 767) {
                    return 1;
                } else if (window.innerWidth <= 1024) {
                    return 2;
                } else {
                    return 4;
                }
            }

            function updateCarousel() {
                innerCarousel.style.setProperty('--items-per-view', itemsPerView);

                const itemWidth = 100 / itemsPerView;
                const translateValue = -index * itemWidth;
                innerCarousel.style.transform = `translateX(${translateValue}%)`;

                const maxIndex = Math.max(0, totalItems - itemsPerView);
                const progressPercentage = maxIndex > 0 ? (index / maxIndex) * 100 : 0;
                line.style.width = `${progressPercentage}%`;
            }

            function goToNext() {
                const maxIndex = Math.max(0, totalItems - itemsPerView);
                if (index < maxIndex) {
                    index++;
                } else {
                    index = 0;
                }
                updateCarousel();
            }

            function goToPrev() {
                const maxIndex = Math.max(0, totalItems - itemsPerView);
                if (index > 0) {
                    index--;
                } else {
                    index = maxIndex;
                }
                updateCarousel();
            }

            nextBtn.addEventListener("click", function(e) {
                e.preventDefault();
                if (!isDragging) {
                    goToNext();
                }
            });

            prevBtn.addEventListener("click", function(e) {
                e.preventDefault();
                if (!isDragging) {
                    goToPrev();
                }
            });

            function dragStart(event) {
                isDragging = true;

                if (event.type === 'touchstart') {
                    startPos = event.touches[0].clientX;
                } else {
                    startPos = event.clientX;
                    event.preventDefault();
                }

                const currentTransform = innerCarousel.style.transform;
                const match = currentTransform.match(/translateX\((-?\d+(?:\.\d+)?)%\)/);
                startTransformValue = match ? parseFloat(match[1]) : 0;

                innerCarousel.style.transition = 'none';
                innerCarousel.style.cursor = 'grabbing';
            }

            function dragMove(event) {
                if (!isDragging) return;

                event.preventDefault();

                const currentPosition = event.type === 'touchmove'
                    ? event.touches[0].clientX
                    : event.clientX;

                const diff = currentPosition - startPos;
                const itemWidth = innerCarousel.parentElement.offsetWidth / itemsPerView;
                const diffPercent = (diff / itemWidth) * (100 / itemsPerView);

                const newTransform = startTransformValue + diffPercent;

                const maxTransform = 0;
                const maxIndex = Math.max(0, totalItems - itemsPerView);
                const minTransform = -(maxIndex * (100 / itemsPerView));
                const limitedTransform = Math.max(minTransform, Math.min(maxTransform, newTransform));

                innerCarousel.style.transform = `translateX(${limitedTransform}%)`;
            }

            function dragEnd(event) {
                if (!isDragging) return;

                isDragging = false;

                const currentPosition = event.type === 'touchend'
                    ? (event.changedTouches ? event.changedTouches[0].clientX : startPos)
                    : event.clientX;

                const diff = currentPosition - startPos;
                const itemWidth = innerCarousel.parentElement.offsetWidth / itemsPerView;

                innerCarousel.style.transition = 'transform 0.3s ease-in-out';
                innerCarousel.style.cursor = 'grab';

                const slidesMoved = Math.round(Math.abs(diff) / itemWidth);
                const minThreshold = itemWidth * 0.15;

                if (Math.abs(diff) > minThreshold && slidesMoved > 0) {
                    const maxIndex = Math.max(0, totalItems - itemsPerView);
                    let newIndex = index;

                    if (diff > 0) {
                        newIndex = Math.max(0, index - slidesMoved);
                    } else {
                        newIndex = Math.min(maxIndex, index + slidesMoved);
                    }

                    index = newIndex;
                    updateCarousel();
                } else {
                    updateCarousel();
                }
            }
            innerCarousel.addEventListener('mousedown', dragStart);
            document.addEventListener('mouseup', dragEnd);
            document.addEventListener('mousemove', dragMove);

            innerCarousel.addEventListener('touchstart', dragStart, { passive: false });
            document.addEventListener('touchend', dragEnd);
            document.addEventListener('touchmove', dragMove, { passive: false });

            innerCarousel.addEventListener('selectstart', (e) => e.preventDefault());
            innerCarousel.addEventListener('dragstart', (e) => e.preventDefault());

            innerCarousel.style.cursor = 'grab';

            window.addEventListener("resize", function() {
                itemsPerView = getItemsPerView();
                updateCarousel();
            });

            updateCarousel();
        });
    </script>
</body>

</html>
