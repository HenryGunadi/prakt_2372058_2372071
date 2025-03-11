<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elegant Dashboard | Dashboard</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
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
        @include('layouts.karyawan.sidebar')

        <div class="main-wrapper">
            <!-- ! Main nav -->
            @include('layouts.karyawan.mainNav')
            <!-- ! Main -->
            @include('layouts.karyawan.main')
            <!-- ! Footer -->
            @include('layouts.footer')
        </div>
    </div>
    <!-- Chart library -->
    <script src="{{ asset('asset/plugins/chart.min.js')}}"></script>
    <!-- Icons library -->
    <script src="{{ asset('asset/plugins/feather.min.js')}}"></script>
    <!-- Custom scripts -->
    <script src="{{ asset('asset/js/script.js')}}"></script>
    @yield('ExtraJS')
</body>

</html>
