<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-nav"
                aria-controls="navbar-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('backend/assets/img/avatar/logo.avif') }}" alt="Logo" class="img-fluid">
        </a>

        <div class="collapse navbar-collapse" id="navbar-nav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('sobre') ? 'active' : '' }}" href="#">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('portfolio') ? 'active' : '' }}" href="/portifolio">Portfólio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
