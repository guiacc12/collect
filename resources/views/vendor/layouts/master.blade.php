<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel Vendedor')</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/summernote/summernote-bs4.css') }}">

    <!-- CSS toast -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <!-- CSS datatable -->
    <link rel="stylesheet" href="//cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.bootstrap5.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
            background: linear-gradient(135deg, #e4ccc0 0%, #e5dad4 100%);
            min-height: 100vh;
        }

        .main-content {
            margin-top: 20px;
            padding-bottom: 20px;
            min-height: calc(100vh - 80px);
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .navbar {
            top: 0;
            right: 0;
            left: 0;
            position: fixed;
            display: flex;
            align-items: center;
            justify-content: end;
            z-index: 1000;
        }

        .section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            margin: 20px auto;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .card-statistic-1 {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
        }

        .border-left-primary {
            border-left: 4px solid #203a4e !important;
        }

        .border-left-success {
            border-left: 4px solid #28a745 !important;
        }

        .border-left-warning {
            border-left: 4px solid #ffc107 !important;
        }

        .border-left-info {
            border-left: 4px solid #17a2b8 !important;
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #203a4e, #3b6381);
        }

        .bg-gradient-success {
            background: linear-gradient(45deg, #28a745, #1e7e34);
        }

        .bg-gradient-warning {
            background: linear-gradient(45deg, #ffc107, #e0a800);
        }

        .bg-gradient-info {
            background: linear-gradient(45deg, #17a2b8, #138496);
        }

        .section-header h1 {
            color: #2c3e50;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #203a4e;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn {
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .table thead th {
            background: #203a4e !important;
            color: white !important;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .table-hover tbody tr:hover {
            background-color: #203a4e;
        }

        .badge {
            border-radius: 20px;
            padding: 0.5em 1em;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .card-header {
            border-bottom: none;
            border-radius: 15px 15px 0 0 !important;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(45deg, #203a4e, #3b6381);
            color: white;
            border-radius: 15px 15px 0 0;
            border-bottom: none;
        }

        .fa-spinner {
            color: #6c757d;
            font-size: 1.5rem;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .card-icon {
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .section {
                margin: 10px;
                padding: 20px;
            }

            .table-responsive {
                font-size: 0.85rem;
            }

            .table td, .table th {
                padding: 0.5rem 0.25rem;
                vertical-align: middle;
            }

            .badge {
                font-size: 0.7rem;
                padding: 0.25em 0.5em;
            }

            .btn-sm {
                padding: 0.2rem 0.4rem;
                font-size: 0.75rem;
            }

            .card-statistic-1 .card-header h4 {
                font-size: 0.9rem;
            }

            .card-statistic-1 .card-body span {
                font-size: 1.5rem !important;
            }
        }

        @media (max-width: 576px) {
            .section {
                margin: 5px;
                padding: 15px;
            }

            .section-header h1 {
                font-size: 1.5rem;
            }

            .table td, .table th {
                padding: 0.3rem 0.2rem;
                font-size: 0.8rem;
            }

            .card-statistic-1 .card-header h4 {
                font-size: 0.8rem;
            }

            .card-statistic-1 .card-body span {
                font-size: 1.2rem !important;
            }

            .card-icon {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }
        }

        .main-footer {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 20px 20px;
            text-align: center;
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .main-footer a {
            color: #203a4e;
            text-decoration: none;
        }

        .main-footer a:hover {
            color: #fff;
        }


    </style>

    @stack('styles')
</head>

<body>
    <!-- Start navbar -->
    @include('vendor.vendor-navbar')
    <!-- end navbar -->

    <div class="main-content">
        @yield('content')
    </div>

    <!-- START FOOTER-->
    <footer class="main-footer">
        <div class="footer-left">
            Copyright &copy; 2024 <div class="bullet"></div> Desenvolvido <a
                href="https://github.com/guiacc12">Guilherme Carrera</a>
        </div>
        <div class="footer-right">

        </div>
    </footer>
    <!-- END FOOTER -->

    <!-- General JS Scripts -->
    <script src="{{ asset('backend/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/popper.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/stisla.js') }}"></script>

    <!-- JS Libraries -->
    <script src="{{ asset('backend/assets/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- JS datatable -->
    <script src="//cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.bootstrap5.js"></script>

    <!-- JS SWEET -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template JS File -->
    <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>

    @stack('scripts')
</body>

</html>
