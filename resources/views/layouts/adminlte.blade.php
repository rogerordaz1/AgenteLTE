<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <title>Agentes | @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet"
        href=" https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }} ">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }} ">

    <link href="{{ asset('dist/css/select2.min.css') }}" rel="stylesheet" />


    @yield('css')
</head>

<body class="hold-transition sidebar-mini">


    @yield('body')
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])





    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }} "></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }} "></script>

    <script src="{{ asset('dist/js/select2.full.min.js') }}"></script>
    <script src="{{asset('dist/js/sweetalert.min.js')}}"></script>

    @yield('js')
</body>

</html>
