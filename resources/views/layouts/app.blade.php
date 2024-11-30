<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{Request::is('alertas*')?'active':''}}" href="{{ route('alertas.index') }}"
                        >Alertas urbanas</a>
                    </li>
                    @can("user.index")
                        <li class="nav-item">
                            <a class="nav-link {{Request::is('users*')?'active':''}}" href="{{ route('users.index') }}"
                            >Usuarios</a>
                        </li>
                    @endcan
                    @can("role.index")
                        <li class="nav-item">
                            <a class="nav-link {{Request::is('roles*')?'active':''}}" href="{{ route('roles.index') }}"
                            >Roles</a>
                        </li>
                    @endcan
                    @can("estado.index")
                        <li class="nav-item">
                            <a class="nav-link {{Request::is('estados*')?'active':''}}"
                               href="{{ route('estados.index') }}"
                            >Estados</a>
                        </li>
                    @endcan
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <div class="form-check form-switch nav-link">
                            <input class="form-check-input" type="checkbox" id="theme-switcher">
                            <label class="form-check-label" for="theme-switcher">Tema oscuro</label>
                        </div>
                    </li>
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>

@yield("script")
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const themeSwitcher = document.getElementById("theme-switcher");
        const htmlElement = document.documentElement;
        const savedTheme = localStorage.getItem("theme") || "light";
        htmlElement.setAttribute("data-bs-theme", savedTheme);
        themeSwitcher.checked = savedTheme === "dark";
        themeSwitcher.addEventListener("change", () => {
            const newTheme = themeSwitcher.checked ? "dark" : "light";
            htmlElement.setAttribute("data-bs-theme", newTheme);
            localStorage.setItem("theme", newTheme);
        });
    });
</script>
</body>
</html>
