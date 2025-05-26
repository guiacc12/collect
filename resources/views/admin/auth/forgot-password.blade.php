<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Painel de Controle Administrador &mdash; Collect Club</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset ('backend/assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset ('backend/assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset ('backend/assets/modules/bootstrap-social/bootstrap-social.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset ('backend/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset ('backend/assets/css/components.css') }}">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body style="background: #e5dad4;">
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="{{ asset ('backend/assets/img/collectlogo.png') }}" alt="COLLECTCLUB" width="100" class="shadow-light" style="width: 50%; height:auto; box-shadow:none; border:none">
            </div>

            <div class="card card-primary" style="background: #95b0b6; color: #fff; border:none">
              <div class="card-header"><h4>Recuperar Senha</h4></div>
                <br>
              @if(session('status'))

              <p class="alert alert-warning">
                Foi enviado um link no e-mail, para recuperar sua senha.
              </p>
              @endif

              <div class="card-body">
                <form method="post" action="{{ route('password.email') }}" class="needs-validation" novalidate="">
                @csrf
                  <div class="form-group">

                    <input id="email" type="email" class="form-control" name="email" placeholder="E-MAIL" tabindex="1" value="{{ old('email') }}" required autofocus>
                    <div class="invalid-feedback" >
                      @if($errors->get('email'))
                      <code>{{ $errors->first('email') }}</code>
                      @endif
                    </div>
                  </div>





                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" style="background: #203a4e; font-size: 18px">
                      Recuperar
                    </button>
                  </div>

                  <p style="text-align:center;"> <a href="{{ route('login') }}" title="voltar para login" style="color: #fff;">Voltar para login</a>
                </p>
                </form>
              </div>
            </div>
            <div class="mt-5 text-muted text-center" style="color: #203a4e;">
              Criado por <a href="https://github.com/guiacc12" style="color: #203a4e;">Guilherme Carrera</a>
            </div>
            <div class="simple-footer" style="color: #203a4e;" >
              Copyright &copy; Guilherme Carrera 2024
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset ('backend/assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset ('backend/assets/modules/popper.js') }}"></script>
  <script src="{{ asset ('backend/assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset ('backend/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset ('backend/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset ('backend/assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset ('backend/assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="{{ asset ('backend/assets/js/scripts.js') }}"></script>
  <script src="{{ asset ('backend/assets/js/custom.js') }}"></script>
</body>
</html>
