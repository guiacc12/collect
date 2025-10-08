<nav class="navbar navbar-expand-lg navbar-dark minimal-nav w-100">
    <div class="container-fluid px-4">
        <a class="navbar-brand minimal-brand" href="{{ url('/') }}">
            <img src="{{ asset('backend/assets/img/avatar/logo.avif') }}" alt="Logo" class="minimal-logo">
        </a>

        <button class="navbar-toggler minimal-toggler" type="button" data-toggle="collapse" data-target="#navbar-nav"
                aria-controls="navbar-nav" aria-expanded="false" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-nav">
            <ul class="navbar-nav minimal-menu">
                <li class="nav-item">
                    <a class="nav-link minimal-link {{ request()->is('/') ? 'active' : '' }}" href="/">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link minimal-link {{ request()->is('sobre') ? 'active' : '' }}" href="{{ route('sobre') }}">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link minimal-link {{ request()->is('portfolio') ? 'active' : '' }}" href="/portifolio">Portifólio</a>
                </li>
            </ul>
            
            <div class="navbar-login">
                <a class="nav-link minimal-link login" href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </div>
</nav>
