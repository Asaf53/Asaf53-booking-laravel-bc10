<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.4/dist/bootstrap-table.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
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

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
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
                            @role('partner')
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('properties.create') }}">{{ __('Add new property') }}</a>
                                </li>
                            @endrole
                            @role('client')
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('partner') }}">
                                        @csrf
                                        <button class="nav-link" type="submit">Become Partner</button>
                                    </form>
                                </li>
                            @endrole
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @hasanyrole('client|partner')
                                        <a href="{{ route('profile.show') }}" class="dropdown-item">Dashboard</a>
                                    @endhasanyrole
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

        <main>
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.4/dist/bootstrap-table.min.js"></script>
    <script>
        $("#checkin_chekout").daterangepicker();
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="country_id"]').on('change', function() {
                var countryID = $(this).val();
                if (countryID) {
                    $.ajax({
                        url: '/city/' + countryID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="city_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="city_id"]').append(
                                    '<option class="text-camelcase" value="' +
                                    key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="city_id"]').empty();
                }
            });
        });
    </script>
    <script>
        function addRoom() {
            var roomTemplate =
                `<div class="room">
                    <hr>
                            <div class="form-floating mb-3">
                                <input type="number" name="capacity[]" class="form-control rounded">
                                <label class="form-label">Capacity</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="price[]" class="form-control rounded">
                                <label class="form-label">Price</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="number[]" class="form-control rounded">
                                <label for="number" class="form-label">Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="singel_beds[]" class="form-control rounded">
                                <label for="singel_beds" class="form-label">Single beds</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="double_beds[]" class="form-control rounded">
                                <label for="double_beds" class="form-label">Double beds</label>
                            </div>
                            <button type="button" onclick="removeRoom(this)" class="btn btn-outline-danger mb-2">Remove</button>
                        </div>
            `;
            document.getElementById('roomFields').insertAdjacentHTML('beforeend', roomTemplate);
        }

        function removeRoom(button) {
            var room = button.parentNode;
            room.parentNode.removeChild(room);
        }
    </script>
</body>

</html>
