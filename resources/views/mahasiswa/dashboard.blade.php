<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegant Dashboard | Dashboard</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom styles -->
    <link rel="stylesheet" href="{{ asset('asset/css/style.min.css')}}">
  @yield('ExtraCss')
</head>
<body>
    <div class="layer"></div>
    <!-- ! Body -->
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">
        <!-- ! Sidebar -->
        @include('mahasiswa.layouts.sidebar')

        <div class="main-wrapper">
            <!-- ! Main nav -->
            @include('mahasiswa.layouts.mainNav')
            <!-- ! Main -->
            @include('mahasiswa.layouts.main')
            <!-- ! Footer -->
            @include('layouts.footer')
        </div>
    </div>
    
    {{-- bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart library -->
    <script src="{{ asset('asset/plugins/chart.min.js')}}"></script>
    <!-- Icons library -->
    <script src="{{ asset('asset/plugins/feather.min.js')}}"></script>
    <!-- Custom scripts -->
    <script src="{{ asset('asset/js/script.js')}}"></script>
    @yield('ExtraJS')
</body>

</html>
