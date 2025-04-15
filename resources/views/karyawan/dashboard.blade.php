<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kaprodi Dashboard | Dashboard</title>
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
        @include('karyawan.layouts.sidebar')
        <div class="main-wrapper">
            @include('karyawan.layouts.mainNav')

            @if (Auth::user()->role->role === 'kaprodi')
                <!-- Show content for 'kaprodi' -->
                @includeWhen($view === 'main', 'karyawan.layouts.surat')
                @includeWhen($view === 'history', 'karyawan.layouts.riwayat')
            @elseif (Auth::user()->role->role === 'tu')
                <!-- Show content for 'tu' -->
                @includeWhen($view === 'main', 'karyawan.layouts.surat_tu')
                @includeWhen($view === 'history', 'karyawan.layouts.riwayat_tu')
            @else
                <!-- Default Content if the role doesn't match -->
                <p>Access Denied or Default View</p>
            @endif
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
