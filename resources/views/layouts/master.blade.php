<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.header')
</head>
<body>

    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">

                @if( Auth::user()->role()->first()->name  == "admin" || Auth::user()->role()->first()->name == "supervisor" )
                    @include('partials.sidebar-header')

                    @include('partials.sidebar-menu')
                @endif

                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            @yield('content')

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2021 &copy; {{ Auth::user()->role()->first()->name }}</p>
                    </div>
                    <div class="float-end">
                        <p>programmeur2020@gmail.com</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>


    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }} "></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('js/flash.js') }}"></script>
    @yield('script')
</body>

</html>



