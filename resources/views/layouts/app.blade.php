<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app" class="mx-auto" style="width:111.1em">
        @auth
            <div class="row gx-0" style="height: 100vh">
                <div class="col-2 bg-dark text-white">
                    <div class="p-4">
                        <div class="text-center mb-5">
                            <h4> <i class="fa fa-car me-2 text-primary" aria-hidden="true"></i> Parking App</h4>
                        </div>
                        @foreach ($in_sidebars as $sidebar)
                            <router-link to="{{ $sidebar['link'] }}" class="text-white text-decoration-none h5 fw-light">
                                <div class="py-3 px-2 mx-3">
                                    @if ($sidebar['icon'] != '')
                                        <i class="fa {{ $sidebar['icon'] }} me-3" aria-hidden="true"></i>
                                    @else
                                        <i class="fa fa-th me-3" aria-hidden="true"></i>
                                    @endif
                                    {{ $sidebar['name'] }}
                                </div>
                            </router-link>
                        @endforeach
                        <div class="p-2 mx-3 mt-5">
                            <a href=" {{ route('logout') }} " class="text-white text-decoration-none h5 fw-light"
                                onclick="event.preventDefault(); document.getElementById('logoutForm').submit()">
                                <i class="nav-icon fa fa-power-off text-danger me-3"></i>
                                Logout
                                <form action=" {{ route('logout') }} " id="logoutForm" method="POST">
                                    @csrf
                                </form>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <router-view></router-view>
                </div>
            </div>
        @else
            <router-view></router-view>
        @endauth

    </div>
</body>

<script>
    @auth
    window.user = @json(auth()->user());
    @endauth
</script>

</html>
